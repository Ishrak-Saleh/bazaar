<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>

<body style="margin: 0; padding: 0; background: #f5f5f5; font-family: Arial, sans-serif; color: #222;">

    <div style="max-width: 650px; margin: 40px auto; background: #ffffff; border-radius: 10px; overflow: hidden; border: 1px solid #e5e5e5;">

        {{-- Header --}}
        <div style="background: #f15a24; padding: 24px 30px; color: #ffffff;">

            <h1 style="margin: 0; font-size: 24px;">
                Bazaar
            </h1>

            <p style="margin: 6px 0 0; font-size: 14px;">
                Password Reset
            </p>

        </div>

        {{-- Content --}}
        <div style="padding: 30px;">

            <h2 style="margin-top: 0; color: #f15a24;">
                Reset Your Password
            </h2>

            <p>
                Hello {{ $user->first_name ?? $user->name }},
            </p>

            <p>
                We received a request to reset the password for your
                Bazaar account.
            </p>

            <p>
                Click the button below to create a new password.
            </p>

            <div style="margin: 30px 0; text-align: center;">

                <a
                    href="{{ $url }}"
                    style="
                        display: inline-block;
                        padding: 12px 24px;
                        background: #f15a24;
                        color: #ffffff;
                        text-decoration: none;
                        border-radius: 6px;
                        font-weight: bold;
                    "
                >
                    Reset Password
                </a>

            </div>

            <div style="margin: 25px 0; padding: 20px; background: #f8f8f8; border-radius: 8px;">

                <h3 style="margin-top: 0;">
                    Important
                </h3>

                <p style="margin-bottom: 0;">
                    This password reset link will expire after 60 minutes.
                    If you did not request a password reset, you can safely
                    ignore this email.
                </p>

            </div>

            <p>
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