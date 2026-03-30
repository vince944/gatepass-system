<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f3f4f6; font-family: Arial, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f3f4f6; padding: 24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width: 620px; background-color: #ffffff; border-radius: 14px; overflow: hidden;">
                    <tr>
                        <td style="background-color: #173A6B; padding: 24px;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 22px; line-height: 1.35;">
                                Development Academy of Philippines
                            </h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 24px;">
                            <p style="margin: 0 0 16px; font-size: 16px; color: #1f2937;">
                                Hello {{ $name }},
                            </p>
                            <p style="margin: 0 0 12px; font-size: 15px; line-height: 1.7; color: #374151;">
                                We received a request to reset your password for your Gatepass Request and Management System account.
                            </p>
                            <p style="margin: 0 0 24px; font-size: 15px; line-height: 1.7; color: #374151;">
                                Click the button below to reset your password.
                            </p>

                            <table role="presentation" cellpadding="0" cellspacing="0" style="margin: 0 0 24px;">
                                <tr>
                                    <td align="center" style="border-radius: 10px; background-color: #F6BF1E;">
                                        <a href="{{ $resetUrl }}" style="display: inline-block; padding: 12px 24px; font-size: 15px; font-weight: 700; color: #173A6B; text-decoration: none; border-radius: 10px;">
                                            Reset Password
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0; font-size: 13px; line-height: 1.7; color: #6b7280;">
                                If you did not request a password reset, no further action is required.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
