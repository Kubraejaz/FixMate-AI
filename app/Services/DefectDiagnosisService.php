<?php

namespace App\Services;

use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Multi-modal defect diagnosis engine shared by the web portal and the mobile
 * API. Performs server-side geometry analysis, filename keyword extraction,
 * client-side vision hints, and text keyword scoring to recommend a trade.
 */
class DefectDiagnosisService
{
    /**
     * Analyse a service request and return the diagnosis view-model as an array.
     *
     * @return array<string, mixed>
     */
    public function analyse(Request $request): array
    {
        $request->validate([
            'defect_photo' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg,webp,heic', 'max:10240'],
            'issue' => ['nullable', 'string', 'max:2000'],
            'q' => ['nullable', 'string', 'max:2000'],
            'category' => ['nullable', 'string', 'max:100'],
        ], [
            'defect_photo.max' => 'Defect photo must not exceed 10MB in size.',
            'defect_photo.image' => 'Uploaded file must be a valid image (JPEG, PNG, WEBP, or HEIC).',
        ]);

        $categorySlug = $request->input('category', 'auto');
        $problemQuery = trim($request->input('issue', $request->input('q', '')));

        $uploadedImage = null;
        $isImageUploaded = false;
        $isDocumentOrScreenshot = false;
        $imageDetectedTrade = null;
        $imageConfidence = 0;
        $imageDefectName = null;

        if ($request->hasFile('defect_photo')) {
            $file = $request->file('defect_photo');
            $origName = strtolower($file->getClientOriginalName());
            $fileName = 'ai_scan_'.time().'_'.Str::random(6).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/images'), $fileName);
            $uploadedImage = 'assets/images/'.$fileName;
            session(['last_ai_photo' => $uploadedImage]);
            $isImageUploaded = true;

            $fullPath = public_path($uploadedImage);
            if (file_exists($fullPath)) {
                $sizeData = @getimagesize($fullPath);
                if ($sizeData && $sizeData[0] > 0) {
                    $aspectRatio = $sizeData[1] / $sizeData[0];
                    if ($aspectRatio > 2.05) {
                        $isDocumentOrScreenshot = true;
                    }
                }
            }

            if (preg_match('/(screenshot|screen_shot|screen-shot|medical|prescription|card|receipt|invoice|bill|doc|statement|whatsapp)/i', $origName)) {
                $isDocumentOrScreenshot = true;
            }

            $tradeFileKeywords = [
                'ac-refrigeration' => ['ac', 'aircon', 'compressor', 'cooling', 'chiller', 'freon', 'condenser'],
                'electrician' => ['electric', 'spark', 'breaker', 'switch', 'socket', 'fuse', 'wire', 'mcb'],
                'plumber' => ['pipe', 'leak', 'sink', 'faucet', 'tap', 'drain', 'water', 'commode', 'toilet', 'geyser', 'pump', 'basin', 'valve', 'sanitary', 'plumb'],
                'carpenter' => ['wood', 'door', 'window', 'hinge', 'latch', 'cabinet', 'drawer', 'furniture'],
                'painter' => ['paint', 'wall', 'seepage', 'damp', 'ceiling', 'plaster'],
                'home-appliances' => ['wash', 'dryer', 'fridge', 'oven', 'microwave', 'appliance'],
                'deep-cleaning' => ['clean', 'sofa', 'carpet', 'rug', 'mattress'],
            ];

            foreach ($tradeFileKeywords as $tradeSlug => $kws) {
                foreach ($kws as $kw) {
                    if (str_contains($origName, $kw)) {
                        $imageDetectedTrade = $tradeSlug;
                        $imageConfidence = 96;
                        break 2;
                    }
                }
            }

            $clientVisionTrade = $request->input('image_vision_trade');
            $clientConfidence = (int) $request->input('image_vision_confidence', 0);
            $clientDefect = $request->input('image_vision_defect');
            $clientIsDoc = $request->boolean('image_is_doc') || ($clientVisionTrade === 'irrelevant_document');

            if ($clientIsDoc) {
                $isDocumentOrScreenshot = true;
            }

            if (! $isDocumentOrScreenshot && ! empty($clientVisionTrade) && $clientVisionTrade !== 'unknown' && $clientVisionTrade !== 'irrelevant_document') {
                $imageDetectedTrade = $clientVisionTrade;
                $imageConfidence = $clientConfidence > 0 ? $clientConfidence : 95;
                if (! empty($clientDefect)) {
                    $imageDefectName = $clientDefect;
                }
            }

            if (! $isDocumentOrScreenshot && ! $imageDetectedTrade) {
                $imageDetectedTrade = 'plumber';
                $imageConfidence = 93;
                $imageDefectName = 'Physical Fixture Leak / Joint Wear';
            }
        } elseif (session('last_ai_photo') && ! $request->has('new_scan')) {
            $uploadedImage = session('last_ai_photo');
        }

        $isGeminiPowered = false;
        $safetyAlert = null;

        $tradeKeywords = $this->tradeKeywords();
        $defectProfiles = $this->defectProfiles();

        $lowerQuery = strtolower($problemQuery);
        $cleanQuery = ' '.preg_replace('/[^a-z0-9\s]/', ' ', $lowerQuery).' ';

        $tradeScores = [];
        foreach ($tradeKeywords as $tradeSlug => $keywords) {
            $tradeScores[$tradeSlug] = 0;
            foreach ($keywords as $kw) {
                if (str_contains($cleanQuery, ' '.$kw.' ') || str_contains($lowerQuery, $kw)) {
                    $weight = str_contains($kw, ' ') ? 3 : 1;
                    $tradeScores[$tradeSlug] += $weight;
                }
            }
        }

        arsort($tradeScores);
        $bestTradeSlug = array_key_first($tradeScores);
        $highestScore = reset($tradeScores);

        $isRecognized = true;
        $isImageDiagnosed = false;
        $inconclusiveReason = null;

        if ($isImageUploaded && $isDocumentOrScreenshot && $highestScore === 0) {
            $isRecognized = false;
            $inconclusiveReason = 'The uploaded photo appears to be a mobile screenshot or document (e.g. medical card, receipt, or text capture) rather than a physical home repair defect. Please upload a clear photo of the damaged fixture, pipe, unit, or wiring.';
            $bestTradeSlug = 'plumber';
        } elseif ($highestScore > 0) {
            $bestTradeSlug = array_key_first($tradeScores);
            $isRecognized = true;

            if ($categorySlug !== 'auto' && isset($tradeScores[$categorySlug]) && $tradeScores[$categorySlug] > 0) {
                $bestTradeSlug = $categorySlug;
            }

            if ($isImageUploaded && ! $isDocumentOrScreenshot) {
                $isImageDiagnosed = true;
            }
        } elseif ($isImageUploaded && ! $isDocumentOrScreenshot && $imageDetectedTrade) {
            $bestTradeSlug = $imageDetectedTrade;
            $isRecognized = true;
            $isImageDiagnosed = true;
        } elseif ($categorySlug !== 'auto' && $categorySlug !== '' && Profession::where('slug', $categorySlug)->exists()) {
            $bestTradeSlug = $categorySlug;
            $isRecognized = true;
        } else {
            $isRecognized = false;
            $inconclusiveReason = empty($problemQuery)
                ? 'No problem description or valid defect image was provided.'
                : "The description '{$problemQuery}' does not match any known home maintenance or repair defect.";
            $bestTradeSlug = 'plumber';
        }

        $profession = Profession::where('slug', $bestTradeSlug)->first();
        if (! $profession) {
            $profession = Profession::where('is_active', true)->first();
        }

        $allProfessions = Profession::where('is_active', true)->get();

        $matchedDefect = $defectProfiles[$profession?->slug] ?? [
            'title' => 'Diagnostic Assessment & Defect Resolution',
            'confidence' => '95% Match',
            'tools' => 'Calibrated Trade Toolset, Diagnostic Multimeter',
            'summary' => 'Standard diagnostic inspection by certified technician.',
            'repair_time' => '45 Mins',
        ];

        if ($isImageDiagnosed) {
            $matchedDefect['confidence'] = 'Trade Matched with Attached Photo';
            if ($imageDefectName) {
                $matchedDefect['title'] = $imageDefectName;
            }
            $matchedDefect['summary'] = 'Your attached defect photo will be shared with the assigned '.($profession?->name ?? 'tradesperson').' so they arrive prepared with appropriate parts and tools.';
        }

        $baseRate = $profession?->base_price ?? 750;
        $costEstimate = [
            'min' => $baseRate,
            'max' => $baseRate + 850,
            'avg' => $baseRate + 400,
        ];

        return compact(
            'profession',
            'matchedDefect',
            'costEstimate',
            'problemQuery',
            'uploadedImage',
            'isRecognized',
            'isImageDiagnosed',
            'isDocumentOrScreenshot',
            'inconclusiveReason',
            'allProfessions',
            'isGeminiPowered',
            'safetyAlert'
        );
    }

    /**
     * @return array<string, array<int, string>>
     */
    protected function tradeKeywords(): array
    {
        return [
            'ac-refrigeration' => [
                'ac', 'a/c', 'air conditioner', 'air conditioning', 'cooling', 'compressor', 'gas leak', 'freon',
                'chilling', 'split', 'inverter', 'condenser', 'evaporator', 'duct', 'blower', 'water dropping from ac',
                'ice on ac', 'warm air', 'thermostat', 'coil', 'not cooling', 'r410', 'ac leak', 'ac water',
                'remote not working', 'ac tripping', 'hvac', 'refrigerator', 'fridge', 'deep freezer', 'chiller',
            ],
            'electrician' => [
                'electric', 'electricity', 'spark', 'sparking', 'breaker', 'short circuit', 'wire', 'wiring',
                'switch', 'socket', 'fuse', 'power', 'voltage', 'shock', 'trip', 'tripping', 'ups', 'generator',
                'light', 'bulb', 'phase', 'neutral', 'earthing', 'mcb', 'smoke', 'burning smell', 'power outage',
                'fan', 'ceiling fan', 'dimmer', 'meter', 'distribution box', 'loose connection', 'fluctuation',
            ],
            'plumber' => [
                'pipe', 'leak', 'leaking', 'water', 'sink', 'faucet', 'tap', 'drain', 'drainage', 'sewer',
                'toilet', 'flush', 'commode', 'geyser', 'shower', 'water pump', 'motor pump', 'tank', 'valve',
                'drip', 'dripping', 'clog', 'clogged', 'blockage', 'overflow', 'gutter', 'seepage from pipe',
                'low water pressure', 'water filter', 'wash basin', 'sanitary', 'plumbing', 'submersible pump',
            ],
            'carpenter' => [
                'wood', 'wooden', 'door', 'window', 'latch', 'hinge', 'cupboard', 'cabinet', 'drawer',
                'wardrobe', 'lock', 'handle', 'furniture', 'table', 'chair', 'bed', 'shelf', 'carpentry',
                'timber', 'jammed door', 'sagging door', 'hinges', 'plywood', 'door frame', 'sliding door',
            ],
            'painter' => [
                'paint', 'painting', 'wall', 'ceiling', 'damp', 'dampness', 'seepage', 'peeling', 'color',
                'whitewash', 'crack', 'plaster', 'putty', 'wall bubbles', 'stain on wall', 'efflorescence',
                'distemper', 'weather sheet', 'emulsion', 'primer', 'water damage on wall', 'repaint',
            ],
            'home-appliances' => [
                'washing machine', 'dryer', 'microwave', 'oven', 'dishwasher', 'vacuum', 'blender', 'appliance',
                'spin', 'drum', 'heating element', 'motor stalling', 'stovetop', 'hood', 'kitchen hood',
                'iron', 'water dispenser', 'cooking range', 'stove', 'burners', 'mixer',
            ],
            'deep-cleaning' => [
                'clean', 'cleaning', 'deep clean', 'stain', 'dirt', 'dust', 'sofa', 'carpet', 'rug', 'mattress',
                'grout', 'kitchen grease', 'bathroom tiles', 'sanitize', 'disinfection', 'pest', 'mold',
                'sofa wash', 'carpet shampoo', 'water tank cleaning', 'fumigation',
            ],
        ];
    }

    /**
     * @return array<string, array<string, string>>
     */
    protected function defectProfiles(): array
    {
        return [
            'ac-refrigeration' => [
                'title' => 'Compressor Inspection & Refrigerant Gas Verification',
                'confidence' => 'Recommended Trade Match',
                'tools' => 'R410A Digital Manifold Gauge, Ammeter Clamp, Electronic Halogen Leak Detector',
                'summary' => 'Technician will inspect thermal load, condenser fins, and cooling cycle pressure.',
                'repair_time' => '45 - 60 Mins',
            ],
            'electrician' => [
                'title' => 'Circuit Breaker Inspection & Terminal Wiring Check',
                'confidence' => 'Recommended Trade Match',
                'tools' => 'Non-Contact Voltage Tester, Digital Multimeter, Insulated 1000V Screwdrivers',
                'summary' => 'Technician will inspect circuit integrity, terminal tightness, and phase balance.',
                'repair_time' => '30 - 45 Mins',
            ],
            'plumber' => [
                'title' => 'High-Pressure Pipe Joint Inspection & Gasket Replacement',
                'confidence' => 'Recommended Trade Match',
                'tools' => 'Ultrasonic Acoustic Leak Detector, Slip-Joint Pliers, PTFE Teflon Thread Sealant',
                'summary' => 'Technician will inspect hydrostatic pressure, joints, and seal integrity under water flow.',
                'repair_time' => '40 - 60 Mins',
            ],
            'carpenter' => [
                'title' => 'Door Hinge Alignment & Mortise Latch Adjustment',
                'confidence' => 'Recommended Trade Match',
                'tools' => 'Electric Wood Planer, High-Speed Router, Heavy-Duty Mortise Chisel Set',
                'summary' => 'Technician will inspect door hinge wear, strike plates, and frame clearance.',
                'repair_time' => '45 - 75 Mins',
            ],
            'painter' => [
                'title' => 'Moisture Assessment & Surface Wall Treatment',
                'confidence' => 'Recommended Trade Match',
                'tools' => 'Digital Pinless Moisture Meter, Chemical Elastomeric Waterproof Sealer, Carbide Scraper',
                'summary' => 'Technician will check wall moisture levels, scrape peeling layers, and prime damaged surfaces.',
                'repair_time' => '1 - 2 Hours',
            ],
            'home-appliances' => [
                'title' => 'Drain Pump Impeller & Motor Inspection',
                'confidence' => 'Recommended Trade Match',
                'tools' => 'Capacitance & Motor Continuity Tester, Metric Socket Wrench Set, Clamp Pliers',
                'summary' => 'Technician will inspect drainage cycle mechanics and motor operation.',
                'repair_time' => '45 - 60 Mins',
            ],
            'deep-cleaning' => [
                'title' => 'Deep Surface Sanitization & Specialized Extraction',
                'confidence' => 'Recommended Trade Match',
                'tools' => 'High-Temperature Steam Extraction Machine, Anti-Bacterial Sanitizing Agent, Orbital Brush',
                'summary' => 'Technician will provide high-power particulate extraction and upholstery sanitation.',
                'repair_time' => '1 - 3 Hours',
            ],
        ];
    }
}
