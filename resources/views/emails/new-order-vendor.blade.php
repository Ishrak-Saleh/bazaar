<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>New Order Received</title>
</head>

<body style="
    margin: 0;
    padding: 0;
    background: #f5f5f5;
    font-family: Arial, sans-serif;
    color: #222;
">

    <div style="
        max-width: 650px;
        margin: 40px auto;
        background: #ffffff;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #e5e5e5;
    ">

        <div style="
            background: #f15a24;
            padding: 24px 30px;
            color: #ffffff;
        ">

            <h1 style="
                margin: 0;
                font-size: 24px;
            ">
                Bazaar
            </h1>

            <p style="
                margin: 6px 0 0;
                font-size: 14px;
            ">
                New Order
            </p>

        </div>


        <div style="padding: 30px;">

            <h2 style="
                margin-top: 0;
                color: #f15a24;
            ">
                New Order Received
            </h2>


            <p>
                Hello {{ $vendor->first_name ?? $vendor->name }},
            </p>


            <p>
                You have received a new order on Bazaar.
                Please review the order details below and process
                the items through your vendor dashboard.
            </p>


            <div style="
                margin: 25px 0;
                padding: 20px;
                background: #f8f8f8;
                border-radius: 8px;
            ">

                <h3 style="margin-top: 0;">
                    Order Details
                </h3>


                <p>
                    <strong>Order Number:</strong>
                    {{ $order->order_number }}
                </p>


                <p>
                    <strong>Customer:</strong>
                    {{ $order->first_name }}
                    {{ $order->last_name }}
                </p>


                <p>
                    <strong>Phone:</strong>
                    {{ $order->phone }}
                </p>


                <p>
                    <strong>Delivery Address:</strong><br>
                    {{ $order->street_address }}<br>
                    {{ $order->city }},
                    {{ $order->postal_code }}
                </p>


                <p>
                    <strong>Payment Method:</strong>
                    {{ strtoupper($order->payment_method) }}
                </p>

            </div>


            <div style="
                margin: 25px 0;
                padding: 20px;
                background: #f8f8f8;
                border-radius: 8px;
            ">

                <h3 style="margin-top: 0;">
                    Your Items
                </h3>


                @foreach($items as $item)

                    <div style="
                        padding: 15px 0;
                        border-bottom: 1px solid #e5e5e5;
                    ">

                        <p style="margin: 0 0 8px;">
                            <strong>
                                {{ $item->product_name }}
                            </strong>
                        </p>

                        <p style="
                            margin: 4px 0;
                            color: #555;
                        ">
                            Quantity: {{ $item->quantity }}
                        </p>

                        <p style="
                            margin: 4px 0;
                            color: #555;
                        ">
                            Unit Price:
                            ৳{{ number_format($item->unit_price, 2) }}
                        </p>

                        <p style="
                            margin: 4px 0;
                            color: #555;
                        ">
                            Item Total:
                            ৳{{ number_format($item->subtotal, 2) }}
                        </p>

                    </div>

                @endforeach

            </div>


            <div style="
                margin: 25px 0;
                padding: 20px;
                background: #fff7f2;
                border-left: 4px solid #f15a24;
                border-radius: 6px;
            ">

                <strong>
                    Your Order Total
                </strong>

                <p style="
                    margin: 8px 0 0;
                    font-size: 20px;
                    font-weight: bold;
                ">
                    ৳{{ number_format($items->sum('subtotal'), 2) }}
                </p>

            </div>


            <p>
                The order is currently marked as
                <strong>Processing</strong>.
            </p>


            <p>
                Please log in to your Bazaar vendor dashboard
                to review and update the order status.
            </p>


            <div style="
                margin: 30px 0;
                text-align: center;
            ">

                <a href="{{ route('vendor.orders.index') }}"
                   style="
                       display: inline-block;
                       padding: 12px 24px;
                       background: #f15a24;
                       color: #ffffff;
                       text-decoration: none;
                       border-radius: 6px;
                       font-weight: bold;
                   ">
                    View Your Orders
                </a>

            </div>


            <p style="margin-top: 30px;">
                Regards,<br>
                <strong>Bazaar Team</strong>
            </p>

        </div>


        <div style="
            padding: 20px 30px;
            background: #f8f8f8;
            color: #777;
            font-size: 12px;
        ">

            This is an automated email from Bazaar.
            Please do not reply directly to this message.

        </div>

    </div>

</body>

</html>