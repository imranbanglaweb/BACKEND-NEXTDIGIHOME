<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProjectInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = ProjectInquiry::query();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority') && $request->priority !== 'all') {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('service')) {
            $query->where('service', 'like', "%{$request->service}%");
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('lead_id', 'like', "%{$search}%")
                    ->orWhere('service', 'like', "%{$search}%");
            });
        }

        $inquiries = $query->latest()->paginate(25);

        return response()->json([
            'success' => true,
            'data' => $inquiries,
        ]);
    }

    public function summary()
    {
        $total = ProjectInquiry::count();
        $new = ProjectInquiry::where('status', 'new')->count();
        $inReview = ProjectInquiry::where('status', 'in_review')->count();
        $contacted = ProjectInquiry::where('status', 'contacted')->count();
        $closed = ProjectInquiry::where('status', 'closed')->count();
        $highPriority = ProjectInquiry::where('priority', 'HIGH')->count();
        $averageScore = $total > 0 ? round(ProjectInquiry::avg('lead_score') ?: 0, 1) : 0;

        return response()->json([
            'success' => true,
            'data' => [
                'total' => $total,
                'new' => $new,
                'in_review' => $inReview,
                'contacted' => $contacted,
                'closed' => $closed,
                'high_priority' => $highPriority,
                'average_score' => $averageScore,
            ],
        ]);
    }

    public function store(Request $request)
    {
        // Honeypot spam check
        if ($request->filled('_hp')) {
            return response()->json([
                'success' => true,
                'message' => 'Your project inquiry has been received.',
            ], 200);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:150',
            'website' => 'nullable|string|max:255',
            'service' => 'required|string|max:150',
            'budget' => 'nullable|string|max:100',
            'timeline' => 'nullable|string|max:100',
            'message' => 'nullable|string|max:8000',
            'description' => 'nullable|string|max:8000',
            'lead_id' => 'nullable|string|max:50',
            'contact_method' => 'nullable|string|max:50',
            'lead_source' => 'nullable|string|max:100',
            'landing_page' => 'nullable|string|max:255',
            'referrer' => 'nullable|string|max:255',
            'priority' => 'nullable|in:LOW,MEDIUM,HIGH,low,medium,high',
            'lead_score' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $message = $request->input('message') ?: $request->input('description') ?: 'Project consultation inquiry.';

            // Generate or capture unique lead ID
            $leadId = $request->input('lead_id');
            if (empty($leadId)) {
                $leadId = 'NDH-' . date('ymd') . rand(1000, 9999);
            }

            // Extract first & last touch attribution
            $firstTouch = $request->input('first_touch_json') ?: [
                'utm_source' => $request->input('first_utm_source') ?: $request->input('utm_source'),
                'utm_medium' => $request->input('first_utm_medium') ?: $request->input('utm_medium'),
                'utm_campaign' => $request->input('first_utm_campaign') ?: $request->input('utm_campaign'),
                'utm_content' => $request->input('first_utm_content') ?: $request->input('utm_content'),
                'utm_term' => $request->input('first_utm_term') ?: $request->input('utm_term'),
                'landing_page' => $request->input('first_landing_page') ?: $request->input('landing_page'),
                'referrer' => $request->input('first_referrer') ?: $request->input('referrer'),
                'timestamp' => $request->input('first_touch_time') ?: now()->toISOString(),
            ];

            $lastTouch = $request->input('last_touch_json') ?: [
                'utm_source' => $request->input('last_utm_source') ?: $request->input('utm_source'),
                'utm_medium' => $request->input('last_utm_medium') ?: $request->input('utm_medium'),
                'utm_campaign' => $request->input('last_utm_campaign') ?: $request->input('utm_campaign'),
                'utm_content' => $request->input('last_utm_content') ?: $request->input('utm_content'),
                'utm_term' => $request->input('last_utm_term') ?: $request->input('utm_term'),
                'landing_page' => $request->input('last_landing_page') ?: $request->input('landing_page'),
                'referrer' => $request->input('last_referrer') ?: $request->input('referrer'),
                'timestamp' => $request->input('last_touch_time') ?: now()->toISOString(),
            ];

            // Calculate lead score if not supplied
            $leadScore = (int) $request->input('lead_score', 0);
            $scoreReasons = $request->input('score_reasons');
            $priority = strtoupper($request->input('priority', ''));

            if ($leadScore <= 0) {
                $scoreCalc = $this->calculateScore([
                    'budget' => $request->input('budget'),
                    'timeline' => $request->input('timeline'),
                    'company' => $request->input('company'),
                    'website' => $request->input('website'),
                    'service' => $request->input('service'),
                    'description' => $message,
                ]);
                $leadScore = $scoreCalc['score'];
                $scoreReasons = $scoreCalc['reasons'];
                if (empty($priority)) {
                    $priority = $scoreCalc['priority'];
                }
            }

            if (empty($priority)) {
                $priority = $leadScore >= 65 ? 'HIGH' : ($leadScore >= 40 ? 'MEDIUM' : 'LOW');
            }

            $inquiry = ProjectInquiry::create([
                'lead_id' => $leadId,
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'whatsapp' => $request->input('whatsapp') ?: $request->input('phone'),
                'company' => $request->input('company'),
                'website' => $request->input('website'),
                'service' => $request->input('service'),
                'service_details' => $request->input('service_details'),
                'budget' => $request->input('budget') ?: 'Not Sure',
                'timeline' => $request->input('timeline') ?: 'Not Sure',
                'contact_method' => $request->input('contact_method') ?: 'Email',
                'lead_source' => $request->input('lead_source') ?: 'Website Direct',
                'landing_page' => $request->input('landing_page') ?: '/contact',
                'referrer' => $request->input('referrer') ?: 'Direct',
                'utm_source' => $request->input('utm_source'),
                'utm_medium' => $request->input('utm_medium'),
                'utm_campaign' => $request->input('utm_campaign'),
                'utm_content' => $request->input('utm_content'),
                'utm_term' => $request->input('utm_term'),
                'first_touch_json' => $firstTouch,
                'last_touch_json' => $lastTouch,
                'event_id' => $request->input('event_id'),
                'message' => $message,
                'file_name' => $request->input('file_name'),
                'file_size' => $request->input('file_size'),
                'file_type' => $request->input('file_type'),
                'status' => 'new',
                'priority' => $priority,
                'lead_score' => $leadScore,
                'score_reasons' => $scoreReasons,
                'notes' => $request->input('notes') ?: [],
                'follow_up' => $request->input('follow_up'),
                'assigned_to' => $request->input('assigned_to'),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            Log::info("New project inquiry saved: #{$inquiry->id} ({$leadId}) from {$inquiry->name} ({$inquiry->email}) - Priority: {$priority}, Score: {$leadScore}");

            // Dispatch Server-Side Tracking (GA4, Meta CAPI, TikTok & Webhooks)
            try {
                app(\App\Services\ServerTrackingService::class)->trackLead($inquiry, $request->all());
            } catch (\Exception $trackingEx) {
                Log::warning("Server tracking dispatch error for inquiry #{$inquiry->id}: " . $trackingEx->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Your project inquiry has been received. Our solutions team will contact you within 24 hours.',
                'data' => [
                    'id' => $inquiry->id,
                    'lead_id' => $inquiry->lead_id,
                    'name' => $inquiry->name,
                    'service' => $inquiry->service,
                    'priority' => $inquiry->priority,
                    'lead_score' => $inquiry->lead_score,
                    'created_at' => $inquiry->created_at->toISOString(),
                ],
            ], 201);
        } catch (\Exception $e) {
            Log::error("Failed to save project inquiry: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to process inquiry. Please contact us directly via WhatsApp or email.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $inquiry = ProjectInquiry::where('id', $id)
            ->orWhere('lead_id', $id)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $inquiry,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,in_review,contacted,closed',
        ]);

        $inquiry = ProjectInquiry::where('id', $id)
            ->orWhere('lead_id', $id)
            ->firstOrFail();

        $inquiry->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Inquiry status updated successfully',
            'data' => $inquiry,
        ]);
    }

    public function updatePriority(Request $request, $id)
    {
        $request->validate([
            'priority' => 'required|in:LOW,MEDIUM,HIGH,low,medium,high',
        ]);

        $inquiry = ProjectInquiry::where('id', $id)
            ->orWhere('lead_id', $id)
            ->firstOrFail();

        $inquiry->update(['priority' => strtoupper($request->priority)]);

        return response()->json([
            'success' => true,
            'message' => 'Inquiry priority updated successfully',
            'data' => $inquiry,
        ]);
    }

    public function addNote(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string|max:2000',
            'author' => 'nullable|string|max:100',
        ]);

        $inquiry = ProjectInquiry::where('id', $id)
            ->orWhere('lead_id', $id)
            ->firstOrFail();

        $currentNotes = is_array($inquiry->notes) ? $inquiry->notes : [];
        $newNote = [
            'id' => 'note_' . time() . '_' . rand(100, 999),
            'text' => trim($request->note),
            'author' => $request->author ?: 'Admin Team',
            'created_at' => now()->toISOString(),
        ];

        array_unshift($currentNotes, $newNote);
        $inquiry->update(['notes' => $currentNotes]);

        return response()->json([
            'success' => true,
            'message' => 'Internal note added successfully',
            'data' => $newNote,
        ]);
    }

    protected function calculateScore(array $data): array
    {
        $score = 20; // Base valid submission
        $reasons = ['Valid inquiry submitted (+20)'];

        $budget = (string) ($data['budget'] ?? '');
        if (str_contains($budget, '3,00,000+') || str_contains($budget, '1,00,000')) {
            $score += 25;
            $reasons[] = 'Enterprise/Growth budget range (+25)';
        } elseif (str_contains($budget, '50,000')) {
            $score += 15;
            $reasons[] = 'Commercial budget tier (+15)';
        }

        $timeline = (string) ($data['timeline'] ?? '');
        if ($timeline === 'ASAP' || str_contains($timeline, '2 Weeks')) {
            $score += 20;
            $reasons[] = 'Urgent deployment timeline (+20)';
        } elseif (str_contains($timeline, '1 Month')) {
            $score += 10;
            $reasons[] = 'Active 1-month timeline (+10)';
        }

        if (!empty($data['company'])) {
            $score += 10;
            $reasons[] = 'Verified Company/Organization (+10)';
        }
        if (!empty($data['website'])) {
            $score += 10;
            $reasons[] = 'Existing web property specified (+10)';
        }

        $service = strtolower((string) ($data['service'] ?? ''));
        if (str_contains($service, 'saas') || str_contains($service, 'software') || str_contains($service, 'ai') || str_contains($service, 'app')) {
            $score += 15;
            $reasons[] = 'High-value core technology domain (+15)';
        }

        if (strlen((string) ($data['description'] ?? '')) > 80) {
            $score += 10;
            $reasons[] = 'Comprehensive project scope details (+10)';
        }

        $priority = $score >= 65 ? 'HIGH' : ($score >= 40 ? 'MEDIUM' : 'LOW');

        return [
            'score' => $score,
            'reasons' => $reasons,
            'priority' => $priority,
        ];
    }
}

