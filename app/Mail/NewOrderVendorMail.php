<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewOrderVendorMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    public User $vendor;

    public $items;

    public function __construct(
        Order $order,
        User $vendor,
        $items
    ) {
        $this->order = $order;
        $this->vendor = $vendor;
        $this->items = $items;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Order Received - ' . $this->order->order_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-order-vendor',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}