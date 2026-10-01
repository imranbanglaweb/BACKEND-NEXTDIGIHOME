<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public $company,
        public $plan,
        public $payment
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Confirmed - Your Subscription is Active',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-confirmed',
        );
    }
}