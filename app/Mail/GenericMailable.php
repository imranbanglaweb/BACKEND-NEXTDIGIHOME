<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Setting;

class GenericMailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The email subject
     *
     * @var string
     */
    public $subject;

    /**
     * The email body content
     *
     * @var string
     */
    public $body;

    /**
     * Optional recipient email
     *
     * @var string|null
     */
    public $email;

    /**
     * Optional action button URL
     *
     * @var string|null
     */
    public $action_url;

    /**
     * Optional action button text
     *
     * @var string|null
     */
    public $action_text;

    /**
     * Create a new message instance
     *
     * @param string $subject
     * @param string $body
     * @param string|null $email
     * @param string|null $action_url
     * @param string|null $action_text
     */
    public function __construct(
        string $subject, 
        string $body,
        ?string $email = null,
        ?string $action_url = null,
        ?string $action_text = null
    ) {
        $this->subject = $subject;
        $this->body = $body;
        $this->email = $email;
        $this->action_url = $action_url;
        $this->action_text = $action_text;
    }

    /**
     * Build the message
     *
     * @return $this
     */
    public function build()
    {
        // Get settings for dynamic branding
        $settings = Setting::first();
        // Generate absolute URL for logo - needed for emails
        $baseUrl = config('app.url', 'http://localhost');
        $logoUrl = $settings && $settings->admin_logo 
            ? $baseUrl . '/public/admin_resource/assets/images/' . $settings->admin_logo
            : null;
        $companyName = $settings && $settings->admin_title ? $settings->admin_title : 'গাড়িবন্ধু ৩৬০';
        
        // Get admin description for tagline
        $adminDescription = '';
        if ($settings && !empty($settings->admin_description)) {
            $adminDescription = $settings->admin_description;
        }
        
        // Check if body is already a complete email template (starts with table tag)
        $isCompleteTemplate = (
            stripos(trim($this->body), '<table') === 0 ||
            stripos($this->body, '<!DOCTYPE') !== false || 
            stripos($this->body, '<html') !== false ||
            stripos($this->body, '<head') !== false ||
            stripos($this->body, '<body') !== false
        );

        if ($isCompleteTemplate) {
            // Send the body directly as complete HTML email
            return $this->subject($this->subject)
                        ->html($this->body);
        } else {
            // Wrap body in premium email layout with dynamic branding
            $wrappedBody = $this->wrapInEmailLayout($this->body, $companyName, $logoUrl, $adminDescription);
            
            return $this->subject($this->subject)
                        ->html($wrappedBody);
        }
    }

    /**
     * Wrap content in premium email layout
     *
     * @param string $body
     * @param string $companyName
     * @param string|null $logoUrl
     * @param string|null $adminDescription
     * @return string
     */
    protected function wrapInEmailLayout(string $body, string $companyName, ?string $logoUrl, ?string $adminDescription = ''): string
    {
        $logoHtml = $logoUrl 
            ? '<img src="' . e($logoUrl) . '" alt="' . e($companyName) . '" style="max-width: 200px; height: auto; display: inline-block; margin-bottom: 10px;">'
            : '<h1 style="margin: 0 0 8px 0; color: #ffffff; font-size: 28px; font-weight: 700; letter-spacing: 0.5px;">' . e($companyName) . '</h1>';
        
        $tagline = !empty($adminDescription) ? '<p class="tagline">' . e($adminDescription) . '</p>' : '';
        $year = date('Y');
        
        $actionButtonHtml = '';
        if ($this->action_url) {
            $buttonText = $this->action_text ?? 'View Details';
            $actionButtonHtml = '
                <div style="margin: 30px 0; text-align: center;">
                    <a href="' . e($this->action_url) . '" style="display: inline-block; padding: 16px 40px; background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%); color: #ffffff; text-decoration: none; font-size: 16px; font-weight: 600; border-radius: 10px; box-shadow: 0 4px 15px rgba(30, 58, 95, 0.4);">
                        ' . e($buttonText) . '
                    </a>
                </div>
            ';
        }
        
        $recipientInfo = $this->email ? 'This email was sent to ' . e($this->email) . '.' : '';
        
        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{$this->subject}</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f5f9; }
        .email-wrapper { padding: 40px 20px; }
        .email-container { max-width: 700px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1); }
        .email-header { background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%); padding: 35px 40px; text-align: center; }
        .email-content { padding: 40px; color: #64748b; font-size: 16px; line-height: 1.8; }
        .email-footer { background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%); padding: 30px 40px; text-align: center; color: rgba(255,255,255,0.9); font-size: 13px; }
        .company-name { font-size: 24px; font-weight: 700; margin-bottom: 10px; }
        .tagline { color: rgba(255,255,255,0.85); font-size: 14px; text-transform: uppercase; letter-spacing: 1px; }
        @media only screen and (max-width: 600px) {
            .email-wrapper { padding: 20px 10px; }
            .email-header, .email-content, .email-footer { padding: 25px 20px; }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <div class="email-header">
                {$logoHtml}
                {$tagline}
            </div>
            <div class="email-content">
                <h2 style="margin: 0 0 25px 0; color: #1e293b; font-size: 24px; font-weight: 700;">Hello,</h2>
                <div>{$body}</div>
                {$actionButtonHtml}
                <div style="margin-top: 30px; padding-top: 25px; border-top: 1px dashed #e2e8f0;">
                    <p style="margin: 0 0 8px 0; color: #1e293b; font-weight: 600;">Best regards,</p>
                    <p style="margin: 0; color: #64748b;">The {$companyName} Team</p>
                </div>
            </div>
            <div class="email-footer">
                <p style="margin: 0 0 10px 0; font-weight: 600; font-size: 16px; color: #ffffff;">{$companyName}</p>
                <p style="margin: 0 0 10px 0; font-size: 12px; color: rgba(255,255,255,0.8);">&copy; {$year} {$companyName}. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
HTML;
    }
}
