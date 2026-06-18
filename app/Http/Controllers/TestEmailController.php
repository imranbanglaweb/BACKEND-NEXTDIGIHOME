<?php

namespace App\Http\Controllers;

use App\Mail\GenericMailable;
use App\Models\EmailLog;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TestEmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.dashboard.email-templates.test', [
            'templates' => EmailTemplate::active()->orderBy('name')->pluck('name', 'id'),
        ]);
    }

    public function preview(Request $request)
    {
        $request->validate([
            'template_id' => ['nullable', 'exists:email_templates,id'],
            'subject' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
        ]);

        [$subject, $body] = $this->resolveMessage($request);

        return response((new GenericMailable($subject, $body))->render());
    }

    public function send(Request $request)
    {
        $request->validate([
            'template_id' => ['nullable', 'exists:email_templates,id'],
            'recipient_email' => ['required', 'email'],
            'subject' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
        ]);

        [$subject, $body] = $this->resolveMessage($request);

        try {
            Mail::to($request->recipient_email)->send(new GenericMailable($subject, $body, $request->recipient_email));

            EmailLog::create([
                'recipient_email' => $request->recipient_email,
                'subject' => $subject,
                'body' => $body,
                'status' => EmailLog::STATUS_SENT,
                'sent_at' => now(),
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Template test email sent successfully.',
            ]);
        } catch (\Throwable $e) {
            EmailLog::create([
                'recipient_email' => $request->recipient_email,
                'subject' => $subject,
                'body' => $body,
                'status' => EmailLog::STATUS_FAILED,
                'error_message' => $e->getMessage(),
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send template email: '.$e->getMessage(),
            ], 500);
        }
    }

    protected function resolveMessage(Request $request): array
    {
        if ($request->filled('body')) {
            return [
                $request->input('subject', 'Test Email'),
                $request->body,
            ];
        }

        $template = EmailTemplate::find($request->template_id);

        if (! $template) {
            abort(422, 'Please select a template or enter custom body content.');
        }

        $rendered = $template->render($this->sampleData());

        return [
            $request->input('subject') ?: $rendered['subject'],
            $rendered['body'],
        ];
    }

    protected function sampleData(): array
    {
        return [
            'requisition_number' => 'REQ-TEST-001',
            'requester_name' => 'Test User',
            'requester_email' => 'test@example.com',
            'department_name' => 'IT',
            'head_name' => 'Department Head',
            'pickup_location' => 'Main Office',
            'dropoff_location' => 'Airport',
            'pickup_date' => now()->format('d M, Y'),
            'pickup_time' => now()->format('H:i'),
            'purpose' => 'Template test email',
            'status' => 'Pending',
            'approval_url' => url('/'),
            'company_name' => config('app.name', 'Next Digi Home'),
            'admin_title' => config('app.name', 'Next Digi Home'),
            'admin_description' => 'Email template test',
            'admin_logo_url' => asset('public/admin_resource/assets/images/default.png'),
            'year' => date('Y'),
        ];
    }
}
