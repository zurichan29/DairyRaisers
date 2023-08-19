<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RejectedMailNotif extends Mailable
{
    use Queueable, SerializesModels;

    public $order; // Add a public property to hold the order data
    /**
     * Create a new message instance.
     */
    public function __construct(array $order)
    {
        $this->order = $order;
    }
    /**
     * Get the message envelope.
     */

     public function build()
    {
        return $this->subject('Order Rejected : ' . $this->order['order_number'])
            ->markdown('components.rejectedOrder')
            ->with('orderData', $this->order);
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Rejected : ' . $this->order['order_number'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
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
