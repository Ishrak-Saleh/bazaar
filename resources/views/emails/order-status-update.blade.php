<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freshness Change Request</title>
</head>

<body style="margin: 0; padding: 0; background: #f5f5f5; font-family: Arial, sans-serif; color: #222;">

    <div style="max-width: 650px; margin: 40px auto; background: #ffffff; border-radius: 10px; overflow: hidden; border: 1px solid #e5e5e5;">

        {{-- Header --}}
        <div style="background: #f15a24; padding: 24px 30px; color: #ffffff;">

            <h1 style="margin: 0; font-size: 24px;">
                Bazaar
            </h1>

            <p style="margin: 6px 0 0; font-size: 14px;">
                Order Update
            </p>

        </div>

        {{-- Content --}}
        <div style="padding: 30px;">

            @if($status === 'processing')

                <h2 style="margin-top: 0; color: #f15a24;">
                    Your Order Is Being Processed
                </h2>

                <p>
                    Hello {{ $order->first_name }},
                </p>

                <p>
                    Your order
                    <strong>{{ $order->order_number }}</strong>
                    is now being processed by the vendor.
                </p>

            @elseif($status === 'ready')

                <h2 style="margin-top: 0; color: #16803c;">
                    Your Order Is Ready
                </h2>

                <p>
                    Hello {{ $order->first_name }},
                </p>

                <p>
                    Your order
                    <strong>{{ $order->order_number }}</strong>
                    is now ready for shipment.
                </p>

            @elseif($status === 'shipped')

                <h2 style="margin-top: 0; color: #16803c;">
                    Your Order Has Been Shipped
                </h2>

                <p>
                    Hello {{ $order->first_name }},
                </p>

                <p>
                    Good news! Your order
                    <strong>{{ $order->order_number }}</strong>
                    has been shipped.
                </p>

            @elseif($status === 'cancelled')

                <h2 style="margin-top: 0; color: #c62828;">
                    Your Order Has Been Cancelled
                </h2>

                <p>
                    Hello {{ $order->first_name }},
                </p>

                <p>
                    Unfortunately, your order
                    <strong>{{ $order->order_number }}</strong>
                    has been cancelled by the vendor.
                </p>

            @endif


            {{-- Order Summary --}}
            <div style="margin: 25px 0; padding: 20px; background: #f8f8f8; border-radius: 8px;">

                <h3 style="margin-top: 0;">
                    Order Details
                </h3>

                <p>
                    <strong>Order Number:</strong>
                    {{ $order->order_number }}
                </p>

                <p>
                    <strong>Product:</strong>
                    {{ $item->product_name }}
                </p>

                <p>
                    <strong>Quantity:</strong>
                    {{ $item->quantity }}
                </p>

                <p>
                    <strong>Item Total:</strong>
                    ৳{{ number_format($item->subtotal, 2) }}
                </p>

                <p>
                    <strong>Order Status:</strong>
                    {{ ucfirst($status) }}
                </p>

            </div>


            {{-- Status-specific message --}}
            @if($status === 'processing')

                <p>
                    The vendor has started preparing your item.
                    You will receive another update when its status changes.
                </p>

            @elseif($status === 'ready')

                <p>
                    Your item has been prepared and is ready to move to the shipping stage.
                </p>

            @elseif($status === 'shipped')

                <p>
                    Your item is now on its way to you.
                    Please keep your phone available for delivery updates.
                </p>

            @elseif($status === 'cancelled')

                <p>
                    The cancelled item will not be shipped.
                    If you believe this cancellation was made in error,
                    please contact the administrator.
                </p>

            @endif


            <p style="margin-top: 30px;">
                Regards,<br>
                <strong>Bazaar Team</strong>
            </p>

        </div>


        {{-- Footer --}}
        <div style="padding: 20px 30px; background: #f8f8f8; color: #777; font-size: 12px;">

            This is an automated email from Bazaar.
            Please do not reply directly to this message.

        </div>

    </div>

</body>
</html>