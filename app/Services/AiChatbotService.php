<?php

namespace App\Services;

use App\Models\AiChatbotSetting;
use App\Models\AiConversation;
use App\Models\AiConversationMessage;
use App\Models\AiKnowledgeItem;
use App\Models\ProjectInquiry;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AiChatbotService
{
    /**
     * Get or create chatbot settings singleton.
     */
    public function getSettings(): AiChatbotSetting
    {
        return AiChatbotSetting::instance();
    }

    /**
     * Update settings
     */
    public function updateSettings(array $data): AiChatbotSetting
    {
        $settings = $this->getSettings();
        $settings->fill($data);
        $settings->save();
        return $settings;
    }

    /**
     * Detect language: Bengali, Banglish, or English
     */
    public function detectLanguage(string $text): string
    {
        // Check for Bengali Unicode characters (U+0980 to U+09FF)
        if (preg_match('/[\x{0980}-\x{09FF}]/u', $text)) {
            return 'bn';
        }

        // Common Banglish words / phonetic tokens
        $banglishPatterns = [
            '/\b(ami|amra|tumi|apni|apnara|apnader|tader|kemon|kivabe|ki vabe|koto|dam|khoroch|taka|lagbe|chai|dorkar|banate|banabo|banaben|korbo|koren|ache|achen|asen|bhalo|valo|shuru|jogajog|thikana|kothay|bujhte|jante|bolun|bolben|ekta|duita|kichu|parbo|hobe|janiye|dite|bikash|bkash|nagad|shob|sobai|webcite|dokaan|dekhte)\b/i',
            '/\b(ki\s+ki|ki\s+kaj|ki\s+service|koto\s+taka|kivabe\s+pabo|kothay\s+achen|jogajog\s+korte)\b/i'
        ];

        foreach ($banglishPatterns as $pattern) {
            if (preg_match($pattern, $text)) {
                return 'banglish';
            }
        }

        return 'en';
    }

    /**
     * Normalize text for fuzzy matching
     */
    protected function normalizeText(string $text): string
    {
        return strtolower(trim(preg_replace('/[^\p{L}\p{N}\s]+/u', ' ', $text)));
    }

    /**
     * RAG: Retrieve relevant knowledge items based on user query
     */
    public function retrieveRelevantKnowledge(string $query, string $lang, int $limit = 4): array
    {
        $normalized = $this->normalizeText($query);
        $tokens = array_filter(explode(' ', $normalized), fn($t) => strlen($t) > 2);

        $items = AiKnowledgeItem::where('is_active', true)->get();
        $scored = [];

        foreach ($items as $item) {
            $score = 0;
            $keywords = strtolower($item->keywords ?? '');
            $title = strtolower($item->title);
            $category = strtolower($item->category);

            // Exact match in title
            if (str_contains($normalized, strtolower($item->title))) {
                $score += 25;
            }

            // Keyword hits
            foreach ($tokens as $token) {
                if (str_contains($title, $token)) {
                    $score += 10;
                }
                if (str_contains($keywords, $token)) {
                    $score += 8;
                }
                if (str_contains($category, $token)) {
                    $score += 5;
                }

                $content = strtolower($item->getContentForLanguage($lang));
                if (str_contains($content, $token)) {
                    $score += 2;
                }
            }

            // Add priority weight
            $score += ($item->priority * 2);

            if ($score > 0) {
                $scored[] = [
                    'item' => $item,
                    'score' => $score
                ];
            }
        }

        usort($scored, fn($a, $b) => $b['score'] <=> $a['score']);
        $topItems = array_slice($scored, 0, $limit);

        // Increment hit count
        foreach ($topItems as $entry) {
            $entry['item']->increment('hit_count');
        }

        return array_map(fn($entry) => $entry['item'], $topItems);
    }

    /**
     * Detect phone and email leads from user message
     */
    public function detectLeadContact(string $message): array
    {
        $lead = [
            'has_lead' => false,
            'phone' => null,
            'email' => null
        ];

        // Phone: Bangladeshi phone formats (01XXXXXXXXX or +8801XXXXXXXXX) or international numbers
        if (preg_match('/(\+?8801[3-9]\d{8}|01[3-9]\d{8}|\+?[1-9]\d{1,14})/', $message, $phoneMatches)) {
            $potentialPhone = preg_replace('/[^\d+]/', '', $phoneMatches[0]);
            if (strlen($potentialPhone) >= 10) {
                $lead['phone'] = $potentialPhone;
                $lead['has_lead'] = true;
            }
        }

        // Email address
        if (preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $message, $emailMatches)) {
            $lead['email'] = strtolower(trim($emailMatches[0]));
            $lead['has_lead'] = true;
        }

        return $lead;
    }

    /**
     * Main Chat Engine: RAG + LLM (Gemini/OpenAI) + Fallback
     */
    public function processChatMessage(
        string $message,
        string $sessionId,
        ?string $preferredLang = null,
        array $clientMeta = []
    ): array {
        $startTime = microtime(true);
        $settings = $this->getSettings();

        // 1. Bot disabled check
        if (!$settings->bot_enabled) {
            return [
                'reply' => "Our AI Assistant is currently offline for scheduled maintenance. Please message our team directly on WhatsApp: {$settings->whatsapp_number} or email {$settings->support_email}.",
                'detectedLanguage' => 'en',
                'suggestedQuestions' => ['WhatsApp Support', 'Email Support'],
                'actions' => [
                    [
                        'label' => 'WhatsApp Support',
                        'url' => "https://wa.me/" . preg_replace('/[^\d]/', '', $settings->whatsapp_number) . "?text=" . urlencode("Hello NextDigiHome"),
                        'type' => 'whatsapp',
                        'isExternal' => true
                    ]
                ],
                'matchedItems' => [],
                'conversationId' => null,
                'messageId' => null,
                'leadCaptured' => false
            ];
        }

        // 2. Language detection
        $lang = $preferredLang ?: $this->detectLanguage($message);

        // 3. Conversation session persistence
        $conversation = AiConversation::firstOrCreate(
            ['session_id' => $sessionId],
            [
                'user_ip' => $clientMeta['ip'] ?? request()->ip(),
                'user_agent' => $clientMeta['user_agent'] ?? request()->userAgent(),
                'device_type' => $clientMeta['device_type'] ?? 'desktop',
                'detected_language' => $lang,
                'first_message' => Str::limit($message, 250),
            ]
        );

        $conversation->increment('message_count');
        $conversation->update([
            'detected_language' => $lang,
            'last_message' => Str::limit($message, 250),
        ]);

        // 4. Save user message
        $userMsg = AiConversationMessage::create([
            'conversation_id' => $conversation->id,
            'sender' => 'user',
            'message' => $message,
            'language' => $lang,
        ]);

        // 5. Check and capture lead if phone or email is detected
        $leadDetection = $this->detectLeadContact($message);
        $leadCaptured = false;

        if ($leadDetection['has_lead'] && $settings->auto_capture_leads) {
            $updateData = ['lead_status' => 'captured'];
            if ($leadDetection['phone']) $updateData['lead_phone'] = $leadDetection['phone'];
            if ($leadDetection['email']) $updateData['lead_email'] = $leadDetection['email'];

            $conversation->update($updateData);
            $leadCaptured = true;

            // Sync to project_inquiries if not synced yet
            if (!$conversation->lead_synced_to_inquiries) {
                try {
                    $inquiry = ProjectInquiry::create([
                        'lead_id' => 'ai_' . substr(md5(uniqid('', true)), 0, 12),
                        'name' => $conversation->lead_name ?: 'Lead from AI Chatbot',
                        'phone' => $leadDetection['phone'] ?: 'N/A',
                        'email' => $leadDetection['email'] ?: 'lead@nextdigihome.com',
                        'service' => 'AI Chatbot Lead Consultation',
                        'message' => "Captured during AI Chatbot session:\n\"{$message}\"",
                        'budget' => 'Discussion',
                        'lead_source' => 'ai_chatbot',
                        'status' => 'new',
                        'ip_address' => $conversation->user_ip,
                        'user_agent' => $conversation->user_agent,
                    ]);

                    $conversation->update([
                        'lead_synced_to_inquiries' => true,
                        'inquiry_id' => $inquiry->id,
                    ]);
                } catch (\Exception $e) {
                    Log::warning('Failed to sync AI lead to inquiries: ' . $e->getMessage());
                }
            }
        }

        // 6. RAG: Knowledge Retrieval
        $retrievedKnowledge = $this->retrieveRelevantKnowledge($message, $lang, 4);
        $retrievedIds = array_map(fn($item) => $item->id, $retrievedKnowledge);

        // Aggregate matched items and action buttons from top knowledge chunks
        $aggregatedActions = [];
        $aggregatedMatchedItems = [];
        $aggregatedSuggestedQuestions = [];

        foreach ($retrievedKnowledge as $kItem) {
            if (!empty($kItem->actions)) {
                foreach ($kItem->actions as $act) {
                    $aggregatedActions[] = $act;
                }
            }
            if (!empty($kItem->matched_items)) {
                foreach ($kItem->matched_items as $mItem) {
                    $aggregatedMatchedItems[] = $mItem;
                }
            }
            if (!empty($kItem->suggested_questions)) {
                foreach ($kItem->suggested_questions as $q) {
                    $aggregatedSuggestedQuestions[] = $q;
                }
            }
        }

        // Deduplicate
        $uniqueActions = array_values(array_unique($aggregatedActions, SORT_REGULAR));
        $uniqueMatchedItems = array_values(array_unique($aggregatedMatchedItems, SORT_REGULAR));
        $uniqueSuggestions = array_values(array_unique($aggregatedSuggestedQuestions));

        // Default actions if empty
        if (empty($uniqueActions)) {
            $waUrl = "https://wa.me/" . preg_replace('/[^\d]/', '', $settings->whatsapp_number) . "?text=" . urlencode("Hello NextDigiHome: {$message}");
            $uniqueActions = [
                ['label' => 'WhatsApp Support', 'url' => $waUrl, 'type' => 'whatsapp', 'isExternal' => true],
                ['label' => 'Explore Solutions', 'url' => '/solutions', 'type' => 'link', 'isExternal' => false],
            ];
        }

        if (empty($uniqueSuggestions)) {
            $uniqueSuggestions = $settings->suggested_chips ?: [
                'ই-কমার্স ওয়েবসাইট খরচ কত?',
                'ParkPulse 360 Parking Demo',
                'Mobile app banate koto lagbe?',
                'Contact & WhatsApp Support'
            ];
        }

        // 7. Generate Response using configured Provider
        $providerUsed = 'local_rag';
        $aiReply = null;
        $tokensUsed = null;

        $primaryProvider = $settings->primary_provider;
        $geminiKey = $settings->gemini_api_key ?: env('GEMINI_API_KEY');
        $openaiKey = $settings->openai_api_key ?: env('OPENAI_API_KEY');

        // Formulate RAG context text for LLM injection
        $ragContextText = "KNOWLEDGE BASE CONTEXT FOR NEXTDIGIHOME:\n";
        foreach ($retrievedKnowledge as $chunk) {
            $ragContextText .= "- Title: {$chunk->title} (Category: {$chunk->category})\n";
            $ragContextText .= "  Content: " . $chunk->getContentForLanguage($lang) . "\n\n";
        }

        // 7A. Try Gemini
        if ($primaryProvider === 'gemini' && !empty($geminiKey)) {
            try {
                $model = $settings->gemini_model ?: 'gemini-1.5-flash';
                $sysPrompt = $settings->system_prompt . "\n\n" . $ragContextText;

                $response = Http::timeout(7)->post(
                    "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$geminiKey}",
                    [
                        'contents' => [
                            [
                                'role' => 'user',
                                'parts' => [
                                    ['text' => "{$sysPrompt}\n\nUser Question ({$lang}): {$message}"]
                                ]
                            ]
                        ],
                        'generationConfig' => [
                            'maxOutputTokens' => $settings->max_tokens ?: 800,
                            'temperature' => (float) ($settings->temperature ?: 0.7),
                        ]
                    ]
                );

                if ($response->successful()) {
                    $resJson = $response->json();
                    $textCandidate = $resJson['candidates'][0]['content']['parts'][0]['text'] ?? null;
                    if (!empty($textCandidate)) {
                        $aiReply = trim($textCandidate);
                        $providerUsed = 'gemini';
                        $tokensUsed = $resJson['usageMetadata']['totalTokenCount'] ?? null;
                    }
                } else {
                    Log::warning('Gemini API call failed: ' . $response->body());
                }
            } catch (\Exception $e) {
                Log::warning('Gemini API exception: ' . $e->getMessage());
            }
        }

        // 7B. Try OpenAI
        if (!$aiReply && ($primaryProvider === 'openai' || $settings->fallback_provider === 'openai') && !empty($openaiKey)) {
            try {
                $model = $settings->openai_model ?: 'gpt-4o-mini';
                $sysPrompt = $settings->system_prompt . "\n\n" . $ragContextText;

                $response = Http::timeout(7)
                    ->withToken($openaiKey)
                    ->post('https://api.openai.com/v1/chat/completions', [
                        'model' => $model,
                        'messages' => [
                            ['role' => 'system', 'content' => $sysPrompt],
                            ['role' => 'user', 'content' => $message],
                        ],
                        'max_tokens' => $settings->max_tokens ?: 800,
                        'temperature' => (float) ($settings->temperature ?: 0.7),
                    ]);

                if ($response->successful()) {
                    $resJson = $response->json();
                    $textCandidate = $resJson['choices'][0]['message']['content'] ?? null;
                    if (!empty($textCandidate)) {
                        $aiReply = trim($textCandidate);
                        $providerUsed = 'openai';
                        $tokensUsed = $resJson['usage']['total_tokens'] ?? null;
                    }
                } else {
                    Log::warning('OpenAI API call failed: ' . $response->body());
                }
            } catch (\Exception $e) {
                Log::warning('OpenAI API exception: ' . $e->getMessage());
            }
        }

        // 7C. Local RAG Fallback if no LLM reply
        if (!$aiReply) {
            $providerUsed = 'local_rag';
            if (!empty($retrievedKnowledge)) {
                $topMatch = $retrievedKnowledge[0];
                $aiReply = $topMatch->getContentForLanguage($lang);
            } else {
                // Friendly generic fallback according to language
                if ($lang === 'bn') {
                    $aiReply = "ধন্যবাদ আপনার বার্তার জন্য! আপনার জিজ্ঞাসিত বিষয়ে আমাদের সিনিয়র সলিউশন কনসালট্যান্টের সাথে দ্রুত কথা বলতে আমাদের হোয়াটসঅ্যাপ নম্বরে যোগাযোগ করুন: **{$settings->whatsapp_number}** অথবা নিচের বাটনে ক্লিক করুন।";
                } elseif ($lang === 'banglish') {
                    $aiReply = "Dhonnobad! Apnar prosner bisoy-e aro bistarito jante ebong direct solution nite amader WhatsApp-e kotha bolun: **{$settings->whatsapp_number}** ba nicher option select korun.";
                } else {
                    $aiReply = "Thank you for reaching out! To get a customized quotation or immediate consultation for your inquiry, please contact our team directly via WhatsApp at **{$settings->whatsapp_number}** or email **{$settings->support_email}**.";
                }
            }
        }

        // If lead was captured in this turn, append warm confirmation
        if ($leadCaptured) {
            $leadConfirmation = "\n\n✅ *We have received your contact details! One of our solution specialists will reach out to you shortly via WhatsApp or Phone.*";
            if ($lang === 'bn') {
                $leadConfirmation = "\n\n✅ *আপনার যোগাযোগের তথ্য গ্রহণ করা হয়েছে! আমাদের স্পেশালিস্ট খুব শীঘ্রই আপনার সাথে যোগাযোগ করবেন।*";
            } elseif ($lang === 'banglish') {
                $leadConfirmation = "\n\n✅ *Apnar contact number receive kora hoyeche! Khub shigghroi amader team theke apnake contact kora hobe.*";
            }
            $aiReply .= $leadConfirmation;
        }

        $responseTimeMs = (int) round((microtime(true) - $startTime) * 1000);

        // 8. Save Bot message
        $botMsg = AiConversationMessage::create([
            'conversation_id' => $conversation->id,
            'sender' => 'bot',
            'message' => $aiReply,
            'language' => $lang,
            'provider_used' => $providerUsed,
            'response_time_ms' => $responseTimeMs,
            'tokens_used' => $tokensUsed,
            'retrieved_knowledge_ids' => $retrievedIds,
            'metadata' => [
                'actions' => $uniqueActions,
                'matched_items' => $uniqueMatchedItems,
                'suggested_questions' => array_slice($uniqueSuggestions, 0, 5)
            ]
        ]);

        return [
            'reply' => $aiReply,
            'detectedLanguage' => $lang,
            'suggestedQuestions' => array_slice($uniqueSuggestions, 0, 5),
            'actions' => $uniqueActions,
            'matchedItems' => $uniqueMatchedItems,
            'conversationId' => $conversation->id,
            'messageId' => $botMsg->id,
            'leadCaptured' => $leadCaptured,
            'provider' => $providerUsed,
            'responseTimeMs' => $responseTimeMs
        ];
    }

    /**
     * Submit feedback on a message (thumbs up / down)
     */
    public function submitFeedback(int $messageId, string $type): bool
    {
        $message = AiConversationMessage::find($messageId);
        if (!$message) return false;

        $feedbackVal = $type === 'like' ? 'like' : 'dislike';
        $message->update(['feedback' => $feedbackVal]);

        // Also update conversation satisfaction score
        if ($message->conversation) {
            $score = $feedbackVal === 'like' ? 1 : -1;
            $message->conversation->update(['satisfaction_score' => $score]);
        }

        return true;
    }

    /**
     * Explicit lead submission from frontend modal/form
     */
    public function captureExplicitLead(string $sessionId, array $data): array
    {
        $conversation = AiConversation::firstOrCreate(['session_id' => $sessionId]);
        
        $name = $data['name'] ?? null;
        $phone = $data['phone'] ?? null;
        $email = $data['email'] ?? null;
        $interest = $data['service'] ?? 'General Consultation';

        $conversation->update([
            'lead_name' => $name ?: $conversation->lead_name,
            'lead_phone' => $phone ?: $conversation->lead_phone,
            'lead_email' => $email ?: $conversation->lead_email,
            'lead_service_interest' => $interest,
            'lead_status' => 'captured',
        ]);

        try {
            $inquiry = ProjectInquiry::create([
                'lead_id' => 'ai_' . substr(md5(uniqid('', true)), 0, 12),
                'name' => $name ?: 'Chatbot Lead',
                'phone' => $phone ?: 'N/A',
                'email' => $email ?: 'lead@nextdigihome.com',
                'service' => $interest,
                'message' => $data['message'] ?? 'Lead submitted via AI Chatbot contact prompt',
                'lead_source' => 'ai_chatbot',
                'status' => 'new',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            $conversation->update([
                'lead_synced_to_inquiries' => true,
                'inquiry_id' => $inquiry->id,
            ]);

            return ['success' => true, 'inquiry_id' => $inquiry->id];
        } catch (\Exception $e) {
            Log::warning('Explicit lead capture error: ' . $e->getMessage());
            return ['success' => true, 'error' => $e->getMessage()];
        }
    }
}
