<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DocumentApproved extends Notification implements ShouldQueue
{
    use Queueable;

    public $tries = 3;
    public $timeout = 60; // Increased timeout
    protected $document;
    protected $approver;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
        $this->approver = Auth::user();
        
        \Log::info('DocumentApproved notification initialized', [
            'document_id' => $document->id,
            'approver' => $this->approver ? $this->approver->id : null
        ]);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        \Log::info('Determining notification channels', [
            'user_id' => $notifiable->id,
            'has_email' => isset($notifiable->email),
            'email' => $notifiable->email ?? 'none'
        ]);

        if (!$notifiable->email) {
            \Log::warning('User has no email address', [
                'user_id' => $notifiable->id
            ]);
            return ['database'];
        }
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        try {
            \Log::info('Starting toMail method', [
                'notifiable_email' => $notifiable->email ?? 'no email',
                'notifiable_name' => $notifiable->name ?? 'no name',
                'document_id' => $this->document->id
            ]);

            if (!$notifiable || !$notifiable->email) {
                \Log::error('Invalid notification recipient');
                return null;
            }

            $url = url('/documents/' . $this->document->id);
            $approverName = $this->approver ? $this->approver->name : 'System';
            $recipientName = $notifiable->name ?? 'User';

            // Prepare data for template
            $data = [
                'recipientName' => $recipientName,
                'projectName' => $this->getProjectName(),
                'landName' => $this->getLandName(),
                'documentType' => $this->getDocumentTypeName(),
                'documentTaker' => $this->document->document_taker,
                'approverName' => $approverName,
                'approvalDate' => now()->format('d M Y H:i:s'),
                'url' => $url,
                'appName' => config('app.name'),
                'document' => $this->document
            ];

            \Log::info('Preparing email with template data', $data);

            return (new MailMessage)
                ->from(config('mail.from.address'), config('mail.from.name'))
                ->subject('Document Approved - ' . $this->getProjectName())
                ->view('emails.documents.approved', $data); // Use view instead of markdown

        } catch (\Exception $e) {
            \Log::error('Error in toMail method', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'notifiable_id' => $notifiable->id ?? 'unknown',
                'document_id' => $this->document->id
            ]);
            throw $e;
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        try {
            return [
                'document_id' => $this->document->id,
                'message' => 'Your document has been approved',
                'project_name' => $this->getProjectName(),
                'land_name' => $this->getLandName(),
                'document_type' => $this->getDocumentTypeName(),
                'approved_by' => $this->approver ? $this->approver->name : 'System',
                'approved_at' => now()->format('d M Y H:i:s')
            ];
        } catch (\Exception $e) {
            \Log::error('Error creating notification array: ' . $e->getMessage());
            return [
                'message' => 'Document approval notification'
            ];
        }
    }

    /**
     * Helper methods to safely get related model names
     */
    private function getProjectName()
    {
        try {
            return optional($this->document->project)->project_name ?? 'N/A';
        } catch (\Exception $e) {
            \Log::error('Error getting project name: ' . $e->getMessage());
            return 'N/A';
        }
    }

    private function getLandName()
    {
        try {
            return optional($this->document->land)->name ?? 'N/A';
        } catch (\Exception $e) {
            \Log::error('Error getting land name: ' . $e->getMessage());
            return 'N/A';
        }
    }

    private function getDocumentTypeName()
    {
        try {
            return optional($this->document->documentType)->name ?? 'N/A';
        } catch (\Exception $e) {
            \Log::error('Error getting document type name: ' . $e->getMessage());
            return 'N/A';
        }
    }
} 