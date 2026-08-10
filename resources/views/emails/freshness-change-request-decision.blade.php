<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freshness Change Request</title>
</head>

<body style="margin: 0; padding: 0; background: #f5f5f5; font-family: Arial, sans-serif; color: #222;">

    <div style="max-width: 650px; margin: 40px auto; background: #ffffff; border-radius: 10px; overflow: hidden; border: 1px solid #e5e5e5;">

        <div style="background: #f15a24; padding: 24px 30px; color: #ffffff;">
            <h1 style="margin: 0; font-size: 24px;">
                Bazaar
            </h1>

            <p style="margin: 6px 0 0; font-size: 14px;">
                Freshness Management
            </p>
        </div>

        <div style="padding: 30px;">

            @if($decision === 'approved')

                <h2 style="margin-top: 0; color: #16803c;">
                    Freshness Change Request Approved
                </h2>

                <p>
                    Hello {{ $freshnessRequest->vendor->fullName() }},
                </p>

                <p>
                    Your request to modify the freshness information for
                    <strong>{{ $freshnessRequest->product->name }}</strong>
                    has been approved by an administrator.
                </p>

            @else

                <h2 style="margin-top: 0; color: #c62828;">
                    Freshness Change Request Denied
                </h2>

                <p>
                    Hello {{ $freshnessRequest->vendor->fullName() }},
                </p>

                <p>
                    Your request to modify the freshness information for
                    <strong>{{ $freshnessRequest->product->name }}</strong>
                    has been denied by an administrator.
                </p>

            @endif

            <div style="margin: 25px 0; padding: 20px; background: #f8f8f8; border-radius: 8px;">

                <h3 style="margin-top: 0;">
                    Request Details
                </h3>

                <p>
                    <strong>Product:</strong>
                    {{ $freshnessRequest->product->name }}
                </p>

                <p>
                    <strong>Current Arrival Date:</strong>
                    {{ optional($freshnessRequest->current_arrival_date)->format('d/m/Y') }}
                </p>

                <p>
                    <strong>Requested Arrival Date:</strong>
                    {{ optional($freshnessRequest->requested_arrival_date)->format('d/m/Y') }}
                </p>

                <p>
                    <strong>Current Shelf Life:</strong>
                    {{ $freshnessRequest->current_shelf_life_days }} days
                </p>

                <p>
                    <strong>Requested Shelf Life:</strong>
                    {{ $freshnessRequest->requested_shelf_life_days }} days
                </p>

                <p>
                    <strong>Your Reason:</strong><br>
                    {{ $freshnessRequest->reason }}
                </p>

            </div>

            @if($freshnessRequest->admin_note)

                <div style="margin: 25px 0; padding: 20px; border-left: 4px solid #f15a24; background: #fff7f2;">

                    <strong>Administrator's Note</strong>

                    <p style="margin-bottom: 0;">
                        {{ $freshnessRequest->admin_note }}
                    </p>

                </div>

            @endif

            @if($decision === 'approved')

                <p>
                    You may now proceed with the approved freshness modification
                    through your vendor dashboard.
                </p>

            @else

                <p>
                    The requested freshness information will remain unchanged.
                    If you believe this decision was made in error, please contact
                    the administrator.
                </p>

            @endif

            <p style="margin-top: 30px;">
                Regards,<br>
                <strong>Bazaar Administration</strong>
            </p>

        </div>

        <div style="padding: 20px 30px; background: #f8f8f8; color: #777; font-size: 12px;">
            This is an automated email from Bazaar. Please do not reply directly
            to this message.
        </div>

    </div>

</body>
</html>