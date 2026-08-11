<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public OrderItem $item;
    public string $status;

    public function __construct(
        Order $order,
        OrderItem $item,
        string $status
    ) {
        $this->order = $order;
        $this->item = $item;
        $this->status = $status;
    }

    public function envelope(): Envelope
    {
        $subject = match ($this->status) {
            'processing' => 'Your Order Is Being Processed',
            'ready' => 'Your Order Is Ready',
            'shipped' => 'Your Order Has Been Shipped',
            'cancelled' => 'Your Order Has Been Cancelled',
            default => 'Order Status Update',
        };

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-status-update',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}