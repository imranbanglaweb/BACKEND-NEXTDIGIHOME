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
            $query = EmailTemplate::query()->latest();
            $types = EmailTemplate::getTemplateTypes();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('type_label', function (EmailTemplate $template) use ($types) {
                    return $types[$template->type] ?? ($template->type ?: 'Custom');
                })
                ->editColumn('subject', function (EmailTemplate $template) {
                    return e(str($template->subject)->limit(60));
                })
                ->editColumn('is_active', function (EmailTemplate $template) {
                    $class = $template->is_active ? 'badge bg-success' : 'badge bg-danger';
                    $label = $template->is_active ? 'Active' : 'Inactive';

                    return '<span class="'.$class.'">'.$label.'</span>';
                })
                ->addColumn('preview', function (EmailTemplate $template) {
                    return '<button type="button" class="btn btn-info btn-sm previewTemplateBtn" data-id="'.$template->id.'" data-name="'.e($template->name).'"><i class="fa fa-eye"></i></button>';
                })
                ->addColumn('action', function (EmailTemplate $template) {
                    $toggleIcon = $template->is_active ? 'fa-toggle-on' : 'fa-toggle-off';
                    $toggleClass = $template->is_active ? 'btn-warning' : 'btn-success';

                    return '
                        <a href="'.route('email-templates.show', $template).'" class="btn btn-info btn-sm" title="View"><i class="fa fa-eye"></i></a>
                        <a href="'.route('email-templates.edit', $template).'" class="btn btn-primary btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                        <button type="button" class="btn '.$toggleClass.' btn-sm toggleStatusBtn" data-id="'.$template->id.'" data-active="'.(int) $template->is_active.'" title="Toggle"><i class="fa '.$toggleIcon.'"></i></button>
                        <button type="button" class="btn btn-danger btn-sm deleteTemplateBtn" data-id="'.$template->id.'" title="Delete"><i class="fa fa-trash"></i></button>
                    ';
                })
                ->rawColumns(['is_active', 'preview', 'action'])
                ->make(true);
        }

        return view('admin.dashboard.email-templates.index');
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
            'requisition_number' => 'REQ-TEST-001',
            'requester_name' => 'Test User',
            'requester_email' => 'test@example.com',
            'department_name' => 'IT',
            'head_name' => 'Department Head',
            'pickup_location' => 'Main Office',
            'dropoff_location' => 'Airport',
            'pickup_date' => now()->format('d M, Y'),
            'pickup_time' => now()->format('H:i'),
            'purpose' => 'Template preview',
            'status' => 'Pending',
            'approval_url' => url('/'),
            'company_name' => config('app.name', 'Next Digi Home'),
            'admin_title' => config('app.name', 'Next Digi Home'),
            'admin_description' => 'Email template preview',
            'admin_logo_url' => asset('public/admin_resource/assets/images/default.png'),
            'year' => date('Y'),
        ];
    }
}
