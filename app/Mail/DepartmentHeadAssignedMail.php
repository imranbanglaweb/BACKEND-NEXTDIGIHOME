<?php

namespace App\Mail;

use App\Models\Department;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Setting;

class DepartmentHeadAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $department;
    public $adminTitle;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Department $department)
    {
        $this->department = $department;
        
        // Get admin title from settings
        $settings = Setting::first();
        $this->adminTitle = $settings && $settings->admin_title ? $settings->admin_title : 'গাড়িবন্ধু ৩৬০';
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Department Head Assignment - ' . $this->adminTitle,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'admin.dashboard.emails.department_head_assigned',
            with: [
                'department' => $this->department,
                'headName' => $this->department->head_name,
                'headEmail' => $this->department->head_email,
                'departmentName' => $this->department->department_name,
                'companyName' => $this->adminTitle,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
