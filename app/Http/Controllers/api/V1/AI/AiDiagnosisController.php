<?php

namespace App\Http\Controllers\Api\V1\AI;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\ProfessionResource;
use App\Services\DefectDiagnosisService;
use App\Services\GeminiAiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AiDiagnosisController extends ApiController
{
    public function diagnose(Request $request, DefectDiagnosisService $diagnosis, GeminiAiService $gemini): JsonResponse
    {
        $result = $diagnosis->analyse($request);

        $payload = [
            'is_recognized' => $result['isRecognized'],
            'is_image_diagnosed' => $result['isImageDiagnosed'],
            'is_document_or_screenshot' => $result['isDocumentOrScreenshot'],
            'inconclusive_reason' => $result['inconclusiveReason'],
            'problem_query' => $result['problemQuery'],
            'uploaded_image' => $result['uploadedImage'] ? asset($result['uploadedImage']) : null,
            'recommended' => [
                'profession' => $result['profession'] ? new ProfessionResource($result['profession']) : null,
                'title' => $result['matchedDefect']['title'] ?? null,
                'confidence' => $result['matchedDefect']['confidence'] ?? null,
                'tools' => $result['matchedDefect']['tools'] ?? null,
                'summary' => $result['matchedDefect']['summary'] ?? null,
                'repair_time' => $result['matchedDefect']['repair_time'] ?? null,
            ],
            'cost_estimate' => $result['costEstimate'],
            'alternatives' => ProfessionResource::collection($result['allProfessions']),
        ];

        if ($gemini->isConfigured() && (! empty($result['problemQuery']) || ! empty($result['uploadedImage']))) {
            $payload['gemini'] = $gemini->diagnoseDefect($result['problemQuery'] ?: null, $result['uploadedImage']);
        }

        return $this->ok($payload, 'Defect diagnosis complete.');
    }
}
