<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * AIService - Handles AI-powered features like maintenance alerts and reporting analysis
 * 
 * This service integrates with OpenAI API for:
 * - Predictive maintenance alerts
 * - AI-powered report generation and analysis
 */
class AIService
{
    protected $apiKey;
    protected $model;
    protected $baseUrl = 'https://api.openai.com/v1';

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
        $this->model = config('services.openai.model', 'gpt-3.5-turbo');
    }

    /**
     * Check if AI features are enabled
     * 
     * @return bool
     */
    public function isEnabled(): bool
    {
        return config('services.openai.enabled', false) && !empty($this->apiKey);
    }

    /**
     * Generate maintenance alert prediction based on vehicle data
     * 
     * @param array $vehicleData
     * @return array
     */
    public function generateMaintenanceAlert(array $vehicleData): array
    {
        if (!$this->isEnabled()) {
            return [
                'success' => false,
                'message' => 'AI features are not enabled',
            ];
        }

        try {
            $prompt = $this->buildMaintenancePrompt($vehicleData);
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/chat/completions', [
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an expert vehicle maintenance assistant. Analyze vehicle data and provide maintenance alerts and recommendations. Return response in JSON format with keys: alert_type, priority, recommendation, estimated_cost, urgency_level.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
                'temperature' => 0.7,
                'max_tokens' => 500,
            ]);

            if ($response->successful()) {
                $content = $response->json()['choices'][0]['message']['content'] ?? '';
                
                return [
                    'success' => true,
                    'analysis' => $this->parseAIResponse($content),
                    'raw_response' => $content,
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to get AI response',
                'error' => $response->body(),
            ];
        } catch (\Exception $e) {
            Log::error('AI Service Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'AI service error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Generate AI-powered report analysis
     * 
     * @param array $reportData
     * @param string $reportType
     * @return array
     */
    public function generateReportAnalysis(array $reportData, string $reportType = 'maintenance'): array
    {
        if (!$this->isEnabled()) {
            return [
                'success' => false,
                'message' => 'AI features are not enabled',
            ];
        }

        try {
            $prompt = $this->buildReportAnalysisPrompt($reportData, $reportType);
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/chat/completions', [
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an expert fleet management analyst. Analyze fleet data and provide actionable insights and recommendations. Return response in JSON format with keys: summary, key_findings, recommendations, cost_analysis, trend_analysis.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
                'temperature' => 0.7,
                'max_tokens' => 1000,
            ]);

            if ($response->successful()) {
                $content = $response->json()['choices'][0]['message']['content'] ?? '';
                
                return [
                    'success' => true,
                    'analysis' => $this->parseAIResponse($content),
                    'raw_response' => $content,
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to get AI response',
                'error' => $response->body(),
            ];
        } catch (\Exception $e) {
            Log::error('AI Report Analysis Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'AI service error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Build maintenance alert prompt
     * 
     * @param array $vehicleData
     * @return string
     */
    protected function buildMaintenancePrompt(array $vehicleData): string
    {
        return "Analyze this vehicle maintenance data and predict potential issues:\n\n" .
               "Vehicle: " . ($vehicleData['registration_number'] ?? 'Unknown') . "\n" .
               "Make/Model: " . ($vehicleData['make_model'] ?? 'Unknown') . "\n" .
               "Age (years): " . ($vehicleData['age'] ?? 'Unknown') . "\n" .
               "Mileage (km): " . ($vehicleData['mileage'] ?? 'Unknown') . "\n" .
               "Last service: " . ($vehicleData['last_service'] ?? 'Unknown') . "\n" .
               "Service interval (km): " . ($vehicleData['service_interval'] ?? 'Unknown') . "\n" .
               "Recent issues: " . ($vehicleData['recent_issues'] ?? 'None') . "\n" .
               "Monthly mileage: " . ($vehicleData['monthly_mileage'] ?? 'Unknown') . "\n\n" .
               "Based on this data, what maintenance should be scheduled? Consider normal wear and tear, expected service intervals, and any emerging issues.";
    }

    /**
     * Build report analysis prompt
     * 
     * @param array $reportData
     * @param string $reportType
     * @return string
     */
    protected function buildReportAnalysisPrompt(array $reportData, string $reportType = 'maintenance'): string
    {
        $dataJson = json_encode($reportData, JSON_PRETTY_PRINT);
        
        return "Analyze this {$reportType} report data for a fleet management system:\n\n" .
               "{$dataJson}\n\n" .
               "Provide:\n" .
               "1. Executive summary of key findings\n" .
               "2. Main issues and their impact\n" .
               "3. Specific recommendations for improvement\n" .
               "4. Cost-benefit analysis\n" .
               "5. Trends and patterns identified\n" .
               "Return analysis as structured JSON.";
    }

    /**
     * Parse AI response - attempt to extract JSON, fallback to string
     * 
     * @param string $response
     * @return array|string
     */
    protected function parseAIResponse(string $response)
    {
        // Try to extract JSON from the response
        if (preg_match('/\{.*\}/s', $response, $matches)) {
            $decoded = json_decode($matches[0], true);
            if ($decoded !== null) {
                return $decoded;
            }
        }
        
        return $response;
    }
}
