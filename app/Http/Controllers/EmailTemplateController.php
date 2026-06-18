<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class EmailTemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $productTypes = array_keys(EmailTemplate::getTemplateTypes());
            $query = EmailTemplate::query()
                ->whereIn('type', $productTypes)
                ->when($request->filled('type'), function ($query) use ($request) {
                    $query->where('type', $request->type);
                })
                ->latest();
            $types = EmailTemplate::getTemplateTypes();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('type_label', function (EmailTemplate $template) use ($types) {
                    $label = $types[$template->type] ?? ($template->type ?: 'Custom');

                    return '<span class="badge badge-type">'.e($label).'</span>';
                })
                ->editColumn('subject', function (EmailTemplate $template) {
                    return e(str($template->subject)->limit(60));
                })
                ->addColumn('variables_count', function (EmailTemplate $template) {
                    return is_array($template->variables) ? count($template->variables) : 0;
                })
                ->editColumn('updated_at', function (EmailTemplate $template) {
                    return optional($template->updated_at)->format('d M Y, h:i A');
                })
                ->editColumn('is_active', function (EmailTemplate $template) {
                    $class = $template->is_active ? 'badge badge-active' : 'badge badge-inactive';
                    $label = $template->is_active ? 'Active' : 'Inactive';

                    return '<span class="'.$class.'">'.$label.'</span>';
                })
                ->addColumn('action', function (EmailTemplate $template) {
                    $toggleIcon = $template->is_active ? 'fa-toggle-on' : 'fa-toggle-off';
                    $toggleClass = $template->is_active ? 'btn-outline-warning' : 'btn-outline-success';
                    $toggleTitle = $template->is_active ? 'Deactivate' : 'Activate';

                    return '
                        <div class="template-actions">
                            <button type="button" class="btn btn-outline-info btn-sm previewTemplateBtn" data-id="'.$template->id.'" data-name="'.e($template->name).'" title="Preview"><i class="fa fa-display"></i></button>
                            <a href="'.route('email-templates.edit', $template).'" class="btn btn-outline-primary btn-sm" title="Edit"><i class="fa fa-pen-to-square"></i></a>
                            <button type="button" class="btn '.$toggleClass.' btn-sm toggleStatusBtn" data-id="'.$template->id.'" data-active="'.(int) $template->is_active.'" title="'.$toggleTitle.'"><i class="fa '.$toggleIcon.'"></i></button>
                            <button type="button" class="btn btn-outline-danger btn-sm deleteTemplateBtn" data-id="'.$template->id.'" title="Delete"><i class="fa fa-trash"></i></button>
                        </div>
                    ';
                })
                ->rawColumns(['type_label', 'is_active', 'action'])
                ->make(true);
        }

        return view('admin.dashboard.email-templates.index', [
            'types' => EmailTemplate::getTemplateTypes(),
            'stats' => [
                'total' => EmailTemplate::whereIn('type', array_keys(EmailTemplate::getTemplateTypes()))->count(),
                'active' => EmailTemplate::whereIn('type', array_keys(EmailTemplate::getTemplateTypes()))->active()->count(),
                'product' => count(EmailTemplate::getTemplateTypes()),
            ],
        ]);
    }

    public function create()
    {
        return view('admin.dashboard.email-templates.create', [
            'types' => EmailTemplate::getTemplateTypes(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = $this->validator($request);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data = $this->validatedData($request);
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        EmailTemplate::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Email template created successfully.',
            'redirect' => route('email-templates.index'),
        ]);
    }

    public function show(EmailTemplate $emailTemplate)
    {
        return view('admin.dashboard.email-templates.show', compact('emailTemplate'));
    }

    public function edit(EmailTemplate $emailTemplate)
    {
        return view('admin.dashboard.email-templates.edit', [
            'emailTemplate' => $emailTemplate,
            'types' => EmailTemplate::getTemplateTypes(),
        ]);
    }

    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $validator = $this->validator($request, $emailTemplate);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data = $this->validatedData($request);
        $data['updated_by'] = auth()->id();

        $emailTemplate->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Email template updated successfully.',
            'redirect' => route('email-templates.index'),
        ]);
    }

    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();

        return response()->json([
            'success' => true,
            'message' => 'Email template deleted successfully.',
        ]);
    }

    public function toggleStatus(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:email_templates,id'],
            'is_active' => ['required', 'boolean'],
        ]);

        $template = EmailTemplate::findOrFail($request->id);
        $template->update([
            'is_active' => $request->boolean('is_active'),
            'updated_by' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Template status updated successfully.',
        ]);
    }

    public function preview(EmailTemplate $emailTemplate)
    {
        $rendered = $emailTemplate->render($this->sampleData());

        return response($rendered['body']);
    }

    protected function validator(Request $request, ?EmailTemplate $emailTemplate = null)
    {
        return Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('email_templates', 'slug')->ignore($emailTemplate?->id),
            ],
            'type' => ['required', 'string', 'max:100'],
            'subject' => ['required', 'string'],
            'body' => ['required', 'string'],
            'variables' => ['nullable', 'json'],
            'is_active' => ['required', 'boolean'],
        ]);
    }

    protected function validatedData(Request $request): array
    {
        return [
            'name' => $request->name,
            'slug' => $request->slug,
            'type' => $request->type,
            'subject' => $request->subject,
            'body' => $request->body,
            'variables' => $request->filled('variables') ? json_decode($request->variables, true) : null,
            'is_active' => $request->boolean('is_active'),
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
