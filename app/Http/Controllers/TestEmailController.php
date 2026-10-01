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
            'customer_name' => 'Ayesha Rahman',
            'customer_email' => 'customer@example.com',
            'transaction_id' => 'NDH-20260618-1001',
            'product_name' => 'Premium Laravel SaaS Kit',
            'product_price' => '49.00',
            'quantity' => '1',
            'total' => '49.00',
            'status' => 'Pending',
            'download_token' => 'sample-download-token',
            'download_url' => url('/api/download/sample-download-token'),
            'access_starts_at' => now()->format('d M Y'),
            'access_expires_at' => now()->addDays(30)->format('d M Y'),
            'remaining_access_days' => 30,
            'validity_label' => '30 days',
            'purchase_type' => 'Digital Download',
            'company_name' => config('app.name', 'Next Digi Home'),
            'admin_title' => config('app.name', 'Next Digi Home'),
            'admin_description' => 'Premium Digital Products Marketplace',
            'admin_logo_url' => asset('public/admin_resource/assets/images/default.png'),
            'year' => date('Y'),
        ];
    }
}
