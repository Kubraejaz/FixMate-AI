<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiAiService
{
    /**
     * Gemini API endpoint base URL.
     */
    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models';

    /**
     * Default Gemini model.
     */
    protected string $model = 'gemini-1.5-flash';

    /**
     * Get the active Gemini API key from settings cache, config, or environment.
     */
    public function getApiKey(): ?string
    {
        return cache('gemini_api_key')
            ?? config('services.gemini.api_key')
            ?? env('GEMINI_API_KEY');
    }

    /**
     * Check if Gemini AI service is configured with an API key.
     */
    public function isConfigured(): bool
    {
        $key = $this->getApiKey();
        return ! empty($key) && strlen(trim($key)) > 10;
    }

    /**
     * Diagnose a repair problem using Google Gemini Multimodal Vision / NLP.
     *
     * @param string|null $problemQuery Text description of the defect
     * @param string|null $imageRelativePath Relative path to public image (e.g. assets/images/ai_scan_...)
     * @return array Result array with success status, provider, and diagnostic data
     */
    public function diagnoseDefect(?string $problemQuery, ?string $imageRelativePath = null): array
    {
        $apiKey = $this->getApiKey();

        if (! $this->isConfigured()) {
            return [
                'success' => false,
                'provider' => 'fallback',
                'reason' => 'Gemini API key is not configured.',
            ];
        }

        try {
            $parts = [];

            // Add image as inline base64 if provided and valid
            if ($imageRelativePath) {
                $fullPath = public_path($imageRelativePath);
                if (file_exists($fullPath) && is_readable($fullPath)) {
                    $mimeType = mime_content_type($fullPath) ?: 'image/jpeg';
                    $fileData = base64_encode(file_get_contents($fullPath));

                    $parts[] = [
                        'inline_data' => [
                            'mime_type' => $mimeType,
                            'data' => $fileData,
                        ],
                    ];
                }
            }

            // Construct inspection prompt
            $userText = ! empty($problemQuery)
                ? "Customer's Reported Issue / Observations: \"{$problemQuery}\""
                : "Analyze the uploaded photograph of this damaged home equipment or household fixture.";

            $promptInstruction = "You are FixMate AI's master certified technical inspection engine for household maintenance and repair.\n"
                . "Your role is to inspect the visual image and/or text description and determine whether it represents a real household maintenance defect, or an irrelevant/non-repair item (such as a document, personal selfie, pet, food, car, text screenshot, or landscape).\n\n"
                . "Valid trades are strictly one of: ac-refrigeration, electrician, plumber, carpenter, painter, home-appliances, deep-cleaning.\n\n"
                . "Respond with a clean JSON object containing EXACTLY these keys:\n"
                . "{\n"
                . "  \"is_repair_defect\": boolean (true if it is a genuine household repair issue, false if it is a document, screenshot, selfie, or unrelated object),\n"
                . "  \"confidence\": integer between 85 and 99,\n"
                . "  \"trade_slug\": string (one of: 'ac-refrigeration', 'electrician', 'plumber', 'carpenter', 'painter', 'home-appliances', 'deep-cleaning', or 'unknown'),\n"
                . "  \"trade_name\": string (e.g. 'Air Conditioning & Refrigeration', 'Electrician', 'Plumber', etc.),\n"
                . "  \"defect_title\": string (precise technical defect name, max 8 words, e.g. 'High-Pressure Pipe Joint Leak & Gasket Wear'),\n"
                . "  \"summary\": string (2-3 concise sentences detailing technical root cause and mechanical/electrical failure mode),\n"
                . "  \"tools\": string (comma-separated list of 3-4 calibrated instruments needed for repair),\n"
                . "  \"repair_time\": string (e.g. '30 - 45 Mins', '1 - 2 Hours'),\n"
                . "  \"cost_min\": integer in PKR (reasonable Pakistani market rate, e.g. 800 - 3500),\n"
                . "  \"cost_max\": integer in PKR (reasonable upper estimate),\n"
                . "  \"safety_alert\": string (crucial safety warning or immediate hazard advice for the homeowner, e.g. 'Shut off main water valve immediately before inspection!')\n"
                . "}";

            $parts[] = [
                'text' => $promptInstruction . "\n\n" . $userText,
            ];

            $modelName = config('services.gemini.model', $this->model);
            $url = "{$this->baseUrl}/{$modelName}:generateContent?key={$apiKey}";

            $response = Http::timeout(12)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, [
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => $parts,
                        ],
                    ],
                    'generationConfig' => [
                        'response_mime_type' => 'application/json',
                        'temperature' => 0.2,
                    ],
                ]);

            if (! $response->successful()) {
                Log::warning('Gemini API request failed', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]);

                return [
                    'success' => false,
                    'provider' => 'fallback',
                    'reason' => 'Gemini API HTTP Error ' . $response->status(),
                ];
            }

            $responseData = $response->json();
            $rawText = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (! $rawText) {
                return [
                    'success' => false,
                    'provider' => 'fallback',
                    'reason' => 'Empty response from Gemini model',
                ];
            }

            $parsed = json_decode($rawText, true);

            if (! is_array($parsed) || ! isset($parsed['is_repair_defect'])) {
                return [
                    'success' => false,
                    'provider' => 'fallback',
                    'reason' => 'Invalid JSON structure returned by Gemini',
                ];
            }

            return [
                'success' => true,
                'provider' => 'gemini',
                'model' => $modelName,
                'data' => [
                    'is_repair_defect' => (bool) $parsed['is_repair_defect'],
                    'confidence' => (int) ($parsed['confidence'] ?? 95),
                    'trade_slug' => (string) ($parsed['trade_slug'] ?? 'unknown'),
                    'trade_name' => (string) ($parsed['trade_name'] ?? 'General Maintenance'),
                    'defect_title' => (string) ($parsed['defect_title'] ?? 'Household Defect Identified'),
                    'summary' => (string) ($parsed['summary'] ?? 'Defect analyzed and classified by AI.'),
                    'tools' => (string) ($parsed['tools'] ?? 'Standard calibrated diagnostic kit'),
                    'repair_time' => (string) ($parsed['repair_time'] ?? '45 Mins'),
                    'cost_min' => (int) ($parsed['cost_min'] ?? 800),
                    'cost_max' => (int) ($parsed['cost_max'] ?? 2000),
                    'safety_alert' => (string) ($parsed['safety_alert'] ?? 'Keep pets and children away from the affected repair area until technician arrives.'),
                ],
            ];
        } catch (\Throwable $e) {
            Log::error('Gemini Service Exception: ' . $e->getMessage());

            return [
                'success' => false,
                'provider' => 'fallback',
                'reason' => $e->getMessage(),
            ];
        }
    }

    /**
     * Test connection to Gemini API.
     */
    public function testConnection(?string $apiKey = null): array
    {
        $key = $apiKey ?: $this->getApiKey();

        if (empty($key)) {
            return [
                'success' => false,
                'message' => 'No Gemini API Key provided.',
            ];
        }

        try {
            $modelName = config('services.gemini.model', $this->model);
            $url = "{$this->baseUrl}/{$modelName}:generateContent?key={$key}";

            $response = Http::timeout(8)->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => 'Respond with single word: OK'],
                        ],
                    ],
                ],
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Successfully connected to Google Gemini API (' . $modelName . ')!',
                ];
            }

            $errorMsg = $response->json('error.message') ?? ('HTTP ' . $response->status());
            return [
                'success' => false,
                'message' => 'Google Gemini API Error: ' . $errorMsg,
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage(),
            ];
        }
    }
}
