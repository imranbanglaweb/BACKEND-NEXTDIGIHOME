<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $templates = $this->templates($now);
        $productTypes = array_column($templates, 'type');

        EmailTemplate::whereNotIn('type', $productTypes)->update(['is_active' => false]);

        foreach ($templates as $template) {
            $emailTemplate = EmailTemplate::withTrashed()->updateOrCreate(
                ['slug' => $template['slug']],
                array_merge($template, [
                    'updated_at' => $now,
                ])
            );

            if ($emailTemplate->trashed()) {
                $emailTemplate->restore();
            }
        }
    }

    private function templates(Carbon $now): array
    {
        return [
            [
                'name' => 'Digital Product Purchase Confirmation',
                'slug' => 'product-purchase-confirmation',
                'subject' => 'Order received: {{product_name}} - {{transaction_id}}',
                'body' => $this->layout(
                    'Order received',
                    'Hi {{customer_name}}, we received your order for {{product_name}}. Your payment is being reviewed and we will send the download link after approval.',
                    [
                        'Transaction ID' => '{{transaction_id}}',
                        'Product' => '{{product_name}}',
                        'Purchase Type' => '{{purchase_type}}',
                        'Quantity' => '{{quantity}}',
                        'Total' => '{{total}}',
                        'Status' => '{{status}}',
                    ],
                    'View Order',
                    '{{download_url}}',
                    'Keep this email for your records. If payment proof is required, submit it from your order page.'
                ),
                'type' => EmailTemplate::TYPE_PRODUCT_PURCHASE_CONFIRMATION,
                'variables' => $this->variables([
                    'customer_name' => 'Customer name',
                    'customer_email' => 'Customer email address',
                    'transaction_id' => 'Purchase transaction ID',
                    'product_name' => 'Purchased digital product name',
                    'product_price' => 'Unit price',
                    'quantity' => 'Purchased quantity',
                    'total' => 'Order total',
                    'status' => 'Current purchase status',
                    'purchase_type' => 'Product purchase/access type',
                    'download_url' => 'Order, payment proof, or download URL',
                ]),
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Payment Proof Submitted Notification',
                'slug' => 'product-payment-submitted',
                'subject' => 'Payment proof submitted: {{transaction_id}}',
                'body' => $this->layout(
                    'Payment proof submitted',
                    'Hi {{customer_name}}, your payment proof for {{product_name}} has been received. Our team will verify it and activate your access shortly.',
                    [
                        'Transaction ID' => '{{transaction_id}}',
                        'Product' => '{{product_name}}',
                        'Customer Email' => '{{customer_email}}',
                        'Amount' => '{{total}}',
                        'Status' => '{{status}}',
                    ],
                    'Check Order Status',
                    '{{download_url}}',
                    'You will receive another email as soon as your payment is verified.'
                ),
                'type' => EmailTemplate::TYPE_PRODUCT_PAYMENT_SUBMITTED,
                'variables' => $this->variables([
                    'customer_name' => 'Customer name',
                    'customer_email' => 'Customer email address',
                    'transaction_id' => 'Purchase transaction ID',
                    'product_name' => 'Purchased digital product name',
                    'total' => 'Order total',
                    'status' => 'Current purchase status',
                    'download_url' => 'Order status URL',
                ]),
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Digital Product Delivery',
                'slug' => 'product-delivery',
                'subject' => 'Your download is ready: {{product_name}}',
                'body' => $this->layout(
                    'Your download is ready',
                    'Hi {{customer_name}}, your payment has been verified. You can now access {{product_name}} using the secure download link below.',
                    [
                        'Transaction ID' => '{{transaction_id}}',
                        'Product' => '{{product_name}}',
                        'Access Starts' => '{{access_starts_at}}',
                        'Access Expires' => '{{access_expires_at}}',
                        'Validity' => '{{validity_label}}',
                        'Remaining Days' => '{{remaining_access_days}}',
                    ],
                    'Download Product',
                    '{{download_url}}',
                    'Do not share this download link. It is connected to your purchase and access period.'
                ),
                'type' => EmailTemplate::TYPE_PRODUCT_DELIVERY,
                'variables' => $this->variables([
                    'customer_name' => 'Customer name',
                    'customer_email' => 'Customer email address',
                    'transaction_id' => 'Purchase transaction ID',
                    'product_name' => 'Purchased digital product name',
                    'download_token' => 'Secure download token',
                    'download_url' => 'Secure download URL',
                    'access_starts_at' => 'Access start date',
                    'access_expires_at' => 'Access expiry date',
                    'remaining_access_days' => 'Remaining access days',
                    'validity_label' => 'Human-readable validity label',
                ]),
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Digital Product Access Expiring',
                'slug' => 'product-access-expiring',
                'subject' => 'Access expires soon: {{product_name}}',
                'body' => $this->layout(
                    'Access expires soon',
                    'Hi {{customer_name}}, your access to {{product_name}} will expire soon. Download your files or renew access before the expiry date.',
                    [
                        'Product' => '{{product_name}}',
                        'Access Expires' => '{{access_expires_at}}',
                        'Remaining Days' => '{{remaining_access_days}}',
                        'Transaction ID' => '{{transaction_id}}',
                    ],
                    'Open My Product',
                    '{{download_url}}',
                    'After expiry, the download link may stop working depending on the product access rules.'
                ),
                'type' => EmailTemplate::TYPE_PRODUCT_ACCESS_EXPIRING,
                'variables' => $this->variables([
                    'customer_name' => 'Customer name',
                    'transaction_id' => 'Purchase transaction ID',
                    'product_name' => 'Purchased digital product name',
                    'download_url' => 'Product access or download URL',
                    'access_expires_at' => 'Access expiry date',
                    'remaining_access_days' => 'Remaining access days',
                ]),
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
    }

    private function variables(array $variables): array
    {
        return array_merge([
            'admin_title' => 'Company title from admin settings',
            'admin_description' => 'Description from admin settings',
            'admin_logo_url' => 'Logo URL from admin settings',
            'company_name' => 'Company name from config',
            'website_url' => 'Public website URL',
            'facebook_page_url' => 'Facebook page URL',
            'related_products_html' => 'HTML block with recommended products',
            'year' => 'Current year',
        ], $variables);
    }

    private function layout(
        string $headline,
        string $intro,
        array $details,
        string $buttonText,
        string $buttonUrl,
        string $note
    ): string {
        $rows = '';

        foreach ($details as $label => $value) {
            $rows .= '
                <tr>
                    <td style="padding: 12px 0; color: #667085; font-size: 13px; border-bottom: 1px solid #eef2f6;">'.$label.'</td>
                    <td style="padding: 12px 0; color: #101828; font-size: 14px; font-weight: 700; text-align: right; border-bottom: 1px solid #eef2f6;">'.$value.'</td>
                </tr>';
        }

        return <<<HTML
<table role="presentation" cellpadding="0" cellspacing="0" style="width:100%; max-width:680px; margin:0 auto; background:#ffffff; border:1px solid #e6eaf0; border-radius:8px; overflow:hidden; font-family:Arial, sans-serif;">
    <tr>
        <td style="background:#101828; padding:28px 32px;">
            <img src="{{admin_logo_url}}" alt="{{admin_title}}" style="height:46px; max-width:180px; object-fit:contain; display:block; margin-bottom:14px;">
            <h1 style="margin:0; color:#ffffff; font-size:24px; line-height:1.3;">{{admin_title}}</h1>
            <p style="margin:8px 0 0; color:#cfd7e6; font-size:14px;">{{admin_description}}</p>
        </td>
    </tr>
    <tr>
        <td style="padding:32px;">
            <h2 style="margin:0 0 14px; color:#101828; font-size:22px;">{$headline}</h2>
            <p style="margin:0 0 24px; color:#475467; font-size:15px; line-height:1.7;">{$intro}</p>

            <table role="presentation" cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse; background:#f8fafc; border:1px solid #eef2f6; border-radius:8px; padding:8px 18px;">
                {$rows}
            </table>

            <div style="text-align:center; margin:30px 0;">
                <a href="{$buttonUrl}" style="display:inline-block; background:#12b76a; color:#ffffff; text-decoration:none; font-size:15px; font-weight:700; padding:14px 26px; border-radius:8px;">{$buttonText}</a>
            </div>

            <p style="margin:0; color:#667085; font-size:13px; line-height:1.6;">{$note}</p>
        </td>
    </tr>
    <tr>
        <td style="padding:26px 32px; background:#f8fafc; border-top:1px solid #eef2f6;">
            <h3 style="margin:0 0 14px; color:#101828; font-size:17px;">Explore more digital products</h3>
            {{related_products_html}}
        </td>
    </tr>
    <tr>
        <td style="background:#101828; padding:20px 32px; border-top:1px solid #1f2937;">
            <table role="presentation" cellpadding="0" cellspacing="0" style="width:100%;">
                <tr>
                    <td style="color:#cbd5e1; font-size:13px;">&copy; {{year}} {{company_name}}. All rights reserved.</td>
                    <td style="text-align:right;">
                        <a href="{{website_url}}" style="color:#ffffff; text-decoration:none; font-size:13px; font-weight:700; margin-right:14px;">Website</a>
                        <a href="{{facebook_page_url}}" style="color:#93c5fd; text-decoration:none; font-size:13px; font-weight:700;">Facebook</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
HTML;
    }
}
