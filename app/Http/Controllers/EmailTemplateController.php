<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use App\Models\Product;
use App\Models\Setting;
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

        return response($this->wrapPreview($rendered['body']));
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
        $settings = Setting::first();
        $websiteUrl = $this->websiteUrl($settings);
        $facebookUrl = $this->facebookUrl();

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
            'admin_title' => $settings->admin_title ?? config('app.name', 'Next Digi Home'),
            'admin_description' => $settings->admin_description ?? 'Premium Digital Products Marketplace',
            'admin_logo_url' => $this->logoUrl($settings),
            'website_url' => $websiteUrl,
            'facebook_page_url' => $facebookUrl,
            'related_products_html' => $this->relatedProductsHtml(),
            'year' => date('Y'),
        ];
    }

    protected function wrapPreview(string $body): string
    {
        return <<<HTML
<div style="background:#eef2f7; padding:28px; border-radius:18px;">
    <table role="presentation" cellpadding="0" cellspacing="0" style="width:100%; max-width:760px; margin:0 auto; background:#ffffff; border-radius:18px; overflow:hidden; box-shadow:0 24px 70px rgba(15,23,42,.16); font-family:Arial, sans-serif;">
        <tr>
            <td style="padding:0; background:#ffffff;">
                {$body}
            </td>
        </tr>
    </table>
</div>
HTML;
    }

    protected function relatedProductsHtml(): string
    {
        $products = Product::query()
            ->where('active', true)
            ->orderByDesc('featured')
            ->latest()
            ->limit(3)
            ->get();

        if ($products->isEmpty()) {
            return '<p style="margin:0; color:#64748b; font-size:13px;">Featured digital products will appear here after products are added.</p>';
        }

        $items = $products->map(function (Product $product) {
            $imageUrl = $this->productImageUrl($product);
            $imageHtml = $imageUrl
                ? '<img src="'.e($imageUrl).'" alt="'.e($product->name).'" style="width:58px; height:58px; border-radius:10px; object-fit:cover; display:block;">'
                : '<div style="width:58px; height:58px; border-radius:10px; background:#e0e7ff; color:#3730a3; display:flex; align-items:center; justify-content:center; font-weight:800;">ND</div>';

            $price = number_format((float) $product->price, 2);
            $url = e(url('/products/'.$product->slug));
            $name = e($product->name);
            $kind = e($product->product_kind_label);

            return <<<HTML
<td style="width:33.333%; padding:0 8px 0 0; vertical-align:top;">
    <a href="{$url}" style="display:block; border:1px solid #e5e7eb; border-radius:12px; padding:12px; background:#ffffff; text-decoration:none;">
        {$imageHtml}
        <div style="color:#111827; font-size:13px; line-height:1.35; font-weight:800; margin-top:10px;">{$name}</div>
        <div style="color:#64748b; font-size:11px; margin-top:4px;">{$kind}</div>
        <div style="color:#16a34a; font-size:13px; font-weight:800; margin-top:8px;">\${$price}</div>
    </a>
</td>
HTML;
        })->implode('');

        return '<table role="presentation" cellpadding="0" cellspacing="0" style="width:100%;"><tr>'.$items.'</tr></table>';
    }

    protected function logoUrl(?Setting $settings): ?string
    {
        if ($settings && $settings->admin_logo) {
            return asset('public/admin_resource/assets/images/'.$settings->admin_logo);
        }

        if ($settings && $settings->site_logo) {
            return asset('public/admin_resource/assets/images/'.$settings->site_logo);
        }

        return null;
    }

    protected function websiteUrl(?Setting $settings): string
    {
        return $settings->canonical_url ?: config('app.url', url('/'));
    }

    protected function facebookUrl(): string
    {
        $contact = \App\Models\ContactInfo::active()
            ->where(function ($query) {
                $query->where('type', 'social')
                    ->orWhere('title', 'like', '%facebook%')
                    ->orWhere('value', 'like', '%facebook.com%');
            })
            ->orderBy('sort_order')
            ->first();

        return $contact->value ?? env('FACEBOOK_PAGE_URL', 'https://www.facebook.com/nextdigihome');
    }

    protected function productImageUrl(Product $product): ?string
    {
        $image = $product->thumbnail ?: $product->og_image;

        if (! $image) {
            return null;
        }

        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
            return $image;
        }

        return asset('public/storage/'.$image);
    }
}
