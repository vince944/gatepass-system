<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation — Development Academy of Philippines</title>
</head>
<body style="margin:0;padding:0;font-family:Segoe UI,Roboto,Helvetica,Arial,sans-serif;background-color:#f0f4f8;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#f0f4f8;padding:24px 12px;">
    <tr>
        <td align="center">
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:560px;background-color:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(23,58,107,0.12);">
                <tr>
                    <td style="background-color:#173A6B;padding:24px 28px;">
                        <h1 style="margin:0;font-size:20px;line-height:1.3;color:#ffffff;">Development Academy of Philippines</h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding:28px 28px 8px;">
                        <p style="margin:0 0 16px;font-size:15px;line-height:1.6;color:#334155;">
                            Hello {{ $employee->employee_name }},
                        </p>
                        <p style="margin:0 0 16px;font-size:15px;line-height:1.6;color:#334155;">
                            You have been invited by admin to join the Gatepass Request and Management System. We're excited to welcome you to our platform!
                        </p>
                        <p style="margin:0 0 8px;font-size:15px;font-weight:600;color:#173A6B;">Your Account Details:</p>
                        <p style="margin:0 0 6px;font-size:15px;line-height:1.6;color:#334155;">Email: {{ $user->email }}</p>
                        <p style="margin:0 0 6px;font-size:15px;line-height:1.6;color:#334155;">Department: {{ $employee->center }}</p>
                        <p style="margin:0 0 20px;font-size:15px;line-height:1.6;color:#334155;">Role: {{ $user->role }}</p>
                        <p style="margin:0 0 20px;font-size:15px;line-height:1.6;color:#334155;">
                            To complete your registration and get started with the Gatepass Request and Management System, please click the button below:
                        </p>
                        <table role="presentation" cellspacing="0" cellpadding="0" style="margin:0 auto;">
                            <tr>
                                <td style="border-radius:8px;background-color:#F6BF1E;">
                                    <a href="{{ $completeRegistrationUrl }}" target="_blank" rel="noopener noreferrer"
                                       style="display:inline-block;padding:14px 28px;font-size:15px;font-weight:700;color:#173A6B;text-decoration:none;">
                                        Complete Registration
                                    </a>
                                </td>
                            </tr>
                        </table>
                        <p style="margin:24px 0 0;font-size:12px;line-height:1.5;color:#64748b;word-break:break-all;">
                            If the button does not work, copy and paste this link into your browser:<br>
                            <span style="color:#173A6B;">{{ $completeRegistrationUrl }}</span>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 28px 28px;">
                        <p style="margin:0;font-size:12px;line-height:1.5;color:#94a3b8;">
                            This link expires in 3 days. If you did not expect this email, you can ignore it.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
