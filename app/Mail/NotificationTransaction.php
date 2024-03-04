<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificationTransaction extends Mailable
{
    use Queueable, SerializesModels;
    public $name, $invoice, $campaigns, $nominal, $payments, $virtualaccount, $status;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->invoice = $data['invoice'];
        $this->campaigns = $data['campaigns'];
        $this->nominal = $data['nominal'];
        $this->payments = $data['payments'];
        $this->virtualaccount = $data['virtualaccount'];
        $this->status = $data['status'];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notification ' . $this->status . ' Transaction',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        switch ($this->status) {
            case 'Success':
                return new Content(
                    view: 'emails.notificationSuccessTransaction',
                );
            case 'Expired':
                return new Content(
                    view: 'emails.notificationExpiredTransaction',
                );

            default:
                return new Content(
                    view: 'emails.notificationCreateTransaction',
                );
        }
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
