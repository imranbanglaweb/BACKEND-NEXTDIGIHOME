<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AiKnowledgeItem;
use App\Services\AiChatbotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AiChatbotApiController extends Controller
{
    protected AiChatbotService $chatbotService;

    public function __construct(AiChatbotService $chatbotService)
    {
        $this->chatbotService = $chatbotService;
    }

    /**
     * Get public AI Chatbot configuration
     */
    public function config(): JsonResponse
    {
        $settings = $this->chatbotService->getSettings();

        return response()->json([
            'bot_enabled' => (bool) $settings->bot_enabled,
            'bot_name' => $settings->bot_name,
            'bot_tagline' => $settings->bot_tagline,
            'bot_avatar' => $settings->bot_avatar,
            'welcome_messages' => [
                'en' => $settings->welcome_msg_en,
                'bn' => $settings->welcome_msg_bn,
                'banglish' => $settings->welcome_msg_banglish,
            ],
            'suggested_chips' => $settings->suggested_chips ?: [
                'ই-কমার্স ওয়েবসাইট খরচ কত?',
                'ParkPulse 360 Parking Demo',
                'Mobile app banate koto lagbe?',
                'AI Chatbot & Automation',
                'Contact & WhatsApp Support'
            ],
            'whatsapp_number' => $settings->whatsapp_number,
            'support_email' => $settings->support_email,
            'support_phone' => $settings->support_phone,
            'sound_enabled_by_default' => (bool) $settings->sound_enabled_by_default,
        ]);
    }

    /**
     * Handle incoming chat message with rate limiting
     */
    public function chat(Request $request): JsonResponse
    {
        $ip = $request->ip();
        $rateLimitKey = 'ai_chat:' . $ip;

        // Rate limit: 30 requests per minute per IP
        if (RateLimiter::tooManyAttempts($rateLimitKey, 30)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return response()->json([
                'reply' => "You have sent too many messages. Please wait {$seconds} seconds before asking again.",
                'detectedLanguage' => 'en',
                'suggestedQuestions' => ['WhatsApp Support'],
                'actions' => [
                    [
                        'label' => 'WhatsApp Support',
                        'url' => 'https://wa.me/8801918329829?text=Hello%20NextDigiHome',
                        'type' => 'whatsapp',
                        'isExternal' => true
                    ]
                ],
                'matchedItems' => []
            ], 429);
        }

        RateLimiter::hit($rateLimitKey, 60);

        $request->validate([
            'message' => 'required|string|max:1500',
            'session_id' => 'nullable|string|max:100',
            'language' => 'nullable|string|in:en,bn,banglish,auto',
        ]);

        $message = trim($request->input('message'));
        $sessionId = $request->input('session_id') ?: ('sess_' . substr(md5($ip . $request->userAgent()), 0, 16));
        $preferredLang = $request->input('language');
        if ($preferredLang === 'auto') {
            $preferredLang = null;
        }

        $clientMeta = [
            'ip' => $ip,
            'user_agent' => $request->userAgent(),
            'device_type' => $this->detectDevice($request->userAgent()),
        ];

        $response = $this->chatbotService->processChatMessage(
            $message,
            $sessionId,
            $preferredLang,
            $clientMeta
        );

        return response()->json($response);
    }

    /**
     * Record feedback on bot message
     */
    public function feedback(Request $request): JsonResponse
    {
        $request->validate([
            'message_id' => 'required|integer',
            'type' => 'required|in:like,dislike'
        ]);

        $success = $this->chatbotService->submitFeedback(
            (int) $request->input('message_id'),
            $request->input('type')
        );

        return response()->json(['success' => $success]);
    }

    /**
     * Capture explicit lead
     */
    public function captureLead(Request $request): JsonResponse
    {
        $request->validate([
            'session_id' => 'required|string',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'name' => 'nullable|string|max:100',
            'service' => 'nullable|string|max:100',
            'message' => 'nullable|string|max:500'
        ]);

        $result = $this->chatbotService->captureExplicitLead(
            $request->input('session_id'),
            $request->all()
        );

        return response()->json($result);
    }

    /**
     * Public Knowledge/Product Catalog Search
     */
    public function searchCatalog(Request $request): JsonResponse
    {
        $query = $request->input('q', '');
        $lang = $request->input('lang', 'en');

        if (empty($query)) {
            $items = AiKnowledgeItem::where('is_active', true)
                ->orderBy('priority', 'desc')
                ->limit(8)
                ->get();
        } else {
            $items = $this->chatbotService->retrieveRelevantKnowledge($query, $lang, 8);
        }

        return response()->json([
            'items' => array_map(function ($it) use ($lang) {
                return [
                    'id' => $it->id,
                    'title' => $it->title,
                    'category' => $it->category,
                    'content' => $it->getContentForLanguage($lang),
                    'actions' => $it->actions,
                    'matched_items' => $it->matched_items
                ];
            }, is_array($items) ? $items : $items->all())
        ]);
    }

    /**
     * Helper to detect mobile vs desktop
     */
    protected function detectDevice(?string $userAgent): string
    {
        if (!$userAgent) return 'desktop';
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', $userAgent)) {
            return 'tablet';
        }
        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', $userAgent)) {
            return 'mobile';
        }
        return 'desktop';
    }
}
