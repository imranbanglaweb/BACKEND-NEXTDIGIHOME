<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiChatbotSetting;
use App\Models\AiConversation;
use App\Models\AiConversationMessage;
use App\Models\AiKnowledgeItem;
use App\Models\ProjectInquiry;
use App\Services\AiChatbotService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class AiChatbotController extends Controller
{
    protected AiChatbotService $chatbotService;

    public function __construct(AiChatbotService $chatbotService)
    {
        $this->chatbotService = $chatbotService;
    }

    /**
     * AI Chatbot Dashboard & Analytics Center
     */
    public function dashboard(Request $request)
    {
        $totalConversations = AiConversation::count();
        $totalMessages = AiConversationMessage::count();
        $totalLeads = AiConversation::whereIn('lead_status', ['captured', 'converted', 'contacted'])->count();

        // Satisfaction metrics
        $thumbsUp = AiConversationMessage::where('feedback', 'like')->count();
        $thumbsDown = AiConversationMessage::where('feedback', 'dislike')->count();
        $totalFeedback = $thumbsUp + $thumbsDown;
        $satisfactionRate = $totalFeedback > 0 ? round(($thumbsUp / $totalFeedback) * 100, 1) : 100.0;

        // Language breakdown
        $bnCount = AiConversation::where('detected_language', 'bn')->count();
        $banglishCount = AiConversation::where('detected_language', 'banglish')->count();
        $enCount = AiConversation::where('detected_language', 'en')->count();

        // Today metrics
        $todayStart = Carbon::today();
        $todayConversations = AiConversation::where('created_at', '>=', $todayStart)->count();
        $todayMessages = AiConversationMessage::where('created_at', '>=', $todayStart)->count();
        $todayLeads = AiConversation::whereIn('lead_status', ['captured', 'converted', 'contacted'])
            ->where('created_at', '>=', $todayStart)->count();

        // Average response time
        $avgResponseTime = (int) AiConversationMessage::whereNotNull('response_time_ms')->avg('response_time_ms');

        // Recent 10 conversations
        $recentConversations = AiConversation::withCount('messages')
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();

        // Daily trend data for the last 14 days
        $days = [];
        $conversationTrends = [];
        $messageTrends = [];

        for ($i = 13; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dateStr = $date->format('Y-m-d');
            $label = $date->format('M d');

            $days[] = $label;
            $conversationTrends[] = AiConversation::whereDate('created_at', $dateStr)->count();
            $messageTrends[] = AiConversationMessage::whereDate('created_at', $dateStr)->count();
        }

        // Top knowledge chunks by hit count
        $topKnowledge = AiKnowledgeItem::orderBy('hit_count', 'desc')->limit(6)->get();

        $settings = $this->chatbotService->getSettings();

        return view('admin.ai-chatbot.dashboard', compact(
            'totalConversations',
            'totalMessages',
            'totalLeads',
            'satisfactionRate',
            'thumbsUp',
            'thumbsDown',
            'bnCount',
            'banglishCount',
            'enCount',
            'todayConversations',
            'todayMessages',
            'todayLeads',
            'avgResponseTime',
            'recentConversations',
            'days',
            'conversationTrends',
            'messageTrends',
            'topKnowledge',
            'settings'
        ));
    }

    /**
     * Conversation History & Session Viewer
     */
    public function conversations(Request $request)
    {
        $query = AiConversation::withCount('messages');

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('session_id', 'like', "%{$search}%")
                  ->orWhere('lead_name', 'like', "%{$search}%")
                  ->orWhere('lead_phone', 'like', "%{$search}%")
                  ->orWhere('lead_email', 'like', "%{$search}%")
                  ->orWhere('first_message', 'like', "%{$search}%")
                  ->orWhere('last_message', 'like', "%{$search}%");
            });
        }

        // Filter by language
        if ($request->filled('language')) {
            $query->where('detected_language', $request->get('language'));
        }

        // Filter by lead status
        if ($request->filled('lead_status')) {
            $query->where('lead_status', $request->get('lead_status'));
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->get('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->get('date_to'));
        }

        $conversations = $query->orderBy('updated_at', 'desc')->paginate(20)->withQueryString();

        return view('admin.ai-chatbot.conversations', compact('conversations'));
    }

    /**
     * Show single conversation messages (AJAX or View)
     */
    public function conversationShow($id)
    {
        $conversation = AiConversation::with(['messages' => function ($q) {
            $q->orderBy('created_at', 'asc');
        }])->findOrFail($id);

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'conversation' => $conversation,
                'messages' => $conversation->messages
            ]);
        }

        return view('admin.ai-chatbot.conversation-detail', compact('conversation'));
    }

    /**
     * Delete a conversation
     */
    public function conversationDestroy($id)
    {
        $conversation = AiConversation::findOrFail($id);
        $conversation->delete();

        return redirect()->back()->with('success', 'Conversation deleted successfully.');
    }

    /**
     * Export conversation logs to CSV
     */
    public function exportConversations(Request $request)
    {
        $conversations = AiConversation::orderBy('created_at', 'desc')->get();

        $csvHeader = [
            'ID', 'Session ID', 'Language', 'Messages Count',
            'Lead Name', 'Lead Phone', 'Lead Email', 'Lead Status',
            'Satisfaction', 'First Message', 'Created At'
        ];

        $callback = function () use ($conversations, $csvHeader) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $csvHeader);

            foreach ($conversations as $c) {
                fputcsv($file, [
                    $c->id,
                    $c->session_id,
                    $c->detected_language,
                    $c->message_count,
                    $c->lead_name ?? '',
                    $c->lead_phone ?? '',
                    $c->lead_email ?? '',
                    $c->lead_status,
                    $c->satisfaction_score == 1 ? 'Helpful' : ($c->satisfaction_score == -1 ? 'Unhelpful' : 'None'),
                    $c->first_message,
                    $c->created_at->toDateTimeString(),
                ]);
            }
            fclose($file);
        };

        $filename = 'ai-conversations-' . date('Y-m-d-His') . '.csv';
        return Response::stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Knowledge Base & RAG Chunk Manager
     */
    public function knowledgeBase(Request $request)
    {
        $query = AiKnowledgeItem::query();

        if ($request->filled('category')) {
            $query->where('category', $request->get('category'));
        }

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('keywords', 'like', "%{$search}%")
                  ->orWhere('content_en', 'like', "%{$search}%")
                  ->orWhere('content_bn', 'like', "%{$search}%");
            });
        }

        $items = $query->orderBy('priority', 'desc')->orderBy('hit_count', 'desc')->paginate(15)->withQueryString();
        $categories = AiKnowledgeItem::select('category')->distinct()->pluck('category');

        return view('admin.ai-chatbot.knowledge-base', compact('items', 'categories'));
    }

    public function knowledgeCreate()
    {
        return view('admin.ai-chatbot.knowledge-create');
    }

    public function knowledgeStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:50',
            'keywords' => 'nullable|string',
            'content_en' => 'required|string',
            'content_bn' => 'nullable|string',
            'content_banglish' => 'nullable|string',
            'priority' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['priority'] = $request->input('priority', 0);

        // Decode JSON suggestions and actions if provided
        if ($request->filled('suggested_questions')) {
            $raw = $request->input('suggested_questions');
            $validated['suggested_questions'] = is_array($raw) ? $raw : array_filter(array_map('trim', explode("\n", $raw)));
        }

        if ($request->filled('actions_json')) {
            $validated['actions'] = json_decode($request->input('actions_json'), true);
        }

        if ($request->filled('matched_items_json')) {
            $validated['matched_items'] = json_decode($request->input('matched_items_json'), true);
        }

        AiKnowledgeItem::create($validated);

        return redirect()->route('admin.ai-chatbot.knowledge-base')->with('success', 'Knowledge chunk created successfully.');
    }

    public function knowledgeEdit($id)
    {
        $item = AiKnowledgeItem::findOrFail($id);
        return view('admin.ai-chatbot.knowledge-edit', compact('item'));
    }

    public function knowledgeUpdate(Request $request, $id)
    {
        $item = AiKnowledgeItem::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:50',
            'keywords' => 'nullable|string',
            'content_en' => 'required|string',
            'content_bn' => 'nullable|string',
            'content_banglish' => 'nullable|string',
            'priority' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['priority'] = $request->input('priority', 0);

        if ($request->filled('suggested_questions')) {
            $raw = $request->input('suggested_questions');
            $validated['suggested_questions'] = is_array($raw) ? $raw : array_filter(array_map('trim', explode("\n", $raw)));
        }

        if ($request->filled('actions_json')) {
            $validated['actions'] = json_decode($request->input('actions_json'), true);
        }

        if ($request->filled('matched_items_json')) {
            $validated['matched_items'] = json_decode($request->input('matched_items_json'), true);
        }

        $item->update($validated);

        return redirect()->route('admin.ai-chatbot.knowledge-base')->with('success', 'Knowledge chunk updated successfully.');
    }

    public function knowledgeDestroy($id)
    {
        $item = AiKnowledgeItem::findOrFail($id);
        $item->delete();

        return redirect()->route('admin.ai-chatbot.knowledge-base')->with('success', 'Knowledge chunk deleted.');
    }

    public function knowledgeToggleActive($id)
    {
        $item = AiKnowledgeItem::findOrFail($id);
        $item->update(['is_active' => !$item->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $item->is_active,
            'message' => $item->is_active ? 'Item activated' : 'Item deactivated'
        ]);
    }

    /**
     * Reseed standard software and solutions knowledge
     */
    public function knowledgeSyncDefaults()
    {
        \Illuminate\Support\Facades\Artisan::call('db:seed', [
            '--class' => 'AiChatbotKnowledgeSeeder',
            '--force' => true
        ]);

        return redirect()->route('admin.ai-chatbot.knowledge-base')->with('success', 'Default knowledge base catalog synced successfully.');
    }

    /**
     * Captured AI Leads management
     */
    public function leads(Request $request)
    {
        $query = AiConversation::whereIn('lead_status', ['captured', 'converted', 'contacted']);

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('lead_name', 'like', "%{$search}%")
                  ->orWhere('lead_phone', 'like', "%{$search}%")
                  ->orWhere('lead_email', 'like', "%{$search}%");
            });
        }

        $leads = $query->orderBy('updated_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.ai-chatbot.leads', compact('leads'));
    }

    /**
     * Convert/Sync Lead to Project Inquiry
     */
    public function syncLeadToInquiry($id)
    {
        $conv = AiConversation::findOrFail($id);

        if (!$conv->lead_synced_to_inquiries) {
            $inquiry = ProjectInquiry::create([
                'lead_id' => 'ai_' . substr(md5(uniqid('', true)), 0, 12),
                'name' => $conv->lead_name ?: 'AI Chat Lead',
                'phone' => $conv->lead_phone ?: 'N/A',
                'email' => $conv->lead_email ?: 'lead@nextdigihome.com',
                'service' => $conv->lead_service_interest ?: 'AI Chatbot Consultation',
                'message' => "Manual sync from AI Chat Session: {$conv->session_id}\nFirst Msg: {$conv->first_message}",
                'lead_source' => 'ai_chatbot',
                'status' => 'new',
                'ip_address' => $conv->user_ip,
                'user_agent' => $conv->user_agent,
            ]);

            $conv->update([
                'lead_synced_to_inquiries' => true,
                'inquiry_id' => $inquiry->id,
                'lead_status' => 'converted'
            ]);

            return redirect()->back()->with('success', 'Lead successfully synced to Project Inquiries.');
        }

        return redirect()->back()->with('info', 'This lead is already synced to Project Inquiries.');
    }

    /**
     * Bot Settings & Prompts
     */
    public function settings()
    {
        $settings = $this->chatbotService->getSettings();
        return view('admin.ai-chatbot.settings', compact('settings'));
    }

    /**
     * Update Bot Settings
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'bot_name' => 'required|string|max:100',
            'bot_tagline' => 'nullable|string|max:150',
            'primary_provider' => 'required|string|in:gemini,openai,local_rag',
            'fallback_provider' => 'required|string|in:local_rag,openai,none',
            'gemini_api_key' => 'nullable|string',
            'gemini_model' => 'nullable|string',
            'openai_api_key' => 'nullable|string',
            'openai_model' => 'nullable|string',
            'temperature' => 'nullable|numeric|min:0|max:1',
            'max_tokens' => 'nullable|integer|min:100|max:4000',
            'system_prompt' => 'required|string',
            'welcome_msg_en' => 'required|string',
            'welcome_msg_bn' => 'required|string',
            'welcome_msg_banglish' => 'required|string',
            'whatsapp_number' => 'required|string',
            'support_email' => 'required|email',
            'support_phone' => 'nullable|string',
            'suggested_chips_text' => 'nullable|string',
        ]);

        $validated['bot_enabled'] = $request->has('bot_enabled');
        $validated['auto_capture_leads'] = $request->has('auto_capture_leads');
        $validated['sound_enabled_by_default'] = $request->has('sound_enabled_by_default');
        $validated['lead_notification_email'] = $request->has('lead_notification_email');

        // Parse suggested chips
        if ($request->filled('suggested_chips_text')) {
            $validated['suggested_chips'] = array_values(array_filter(array_map('trim', explode("\n", $request->input('suggested_chips_text')))));
        }

        // If API key is masked (e.g. ends with ***), do not overwrite with masked string
        if (str_contains($request->input('gemini_api_key', ''), '***')) {
            unset($validated['gemini_api_key']);
        }
        if (str_contains($request->input('openai_api_key', ''), '***')) {
            unset($validated['openai_api_key']);
        }

        $this->chatbotService->updateSettings($validated);

        return redirect()->route('admin.ai-chatbot.settings')->with('success', 'AI Chatbot settings updated successfully.');
    }

    /**
     * RAG Playground: Interactive Live Console
     */
    public function playground()
    {
        $settings = $this->chatbotService->getSettings();
        $sampleQueries = [
            'ই-কমার্স ওয়েবসাইট বানাতে কত খরচ?',
            'Tell me about ParkPulse 360 parking system',
            'Garibondhu360 software er features ki ki?',
            'What mobile app frameworks do you use?',
            'Apnader office kothay ebong phone number din'
        ];

        return view('admin.ai-chatbot.playground', compact('settings', 'sampleQueries'));
    }

    /**
     * Playground Test Execution (AJAX)
     */
    public function playgroundExecute(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|string'
        ]);

        $query = $request->input('query');
        $lang = $request->input('language') ?: $this->chatbotService->detectLanguage($query);

        // Retrieve RAG chunks
        $retrieved = $this->chatbotService->retrieveRelevantKnowledge($query, $lang, 4);

        $ragChunks = array_map(function ($item) use ($lang) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'category' => $item->category,
                'priority' => $item->priority,
                'keywords' => $item->keywords,
                'content_preview' => mb_substr($item->getContentForLanguage($lang), 0, 180) . '...',
            ];
        }, $retrieved);

        // Run full chat process
        $sessionId = 'playground-' . session()->getId();
        $result = $this->chatbotService->processChatMessage($query, $sessionId, $lang, [
            'ip' => request()->ip(),
            'user_agent' => 'Playground Console'
        ]);

        return response()->json([
            'success' => true,
            'query' => $query,
            'detectedLanguage' => $lang,
            'retrievedChunks' => $ragChunks,
            'aiResponse' => $result['reply'],
            'provider' => $result['provider'],
            'responseTimeMs' => $result['responseTimeMs'],
            'actions' => $result['actions'],
            'matchedItems' => $result['matchedItems'],
            'suggestedQuestions' => $result['suggestedQuestions']
        ]);
    }
}
