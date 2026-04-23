<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New gate pass request</title>
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
                            A gate pass request has been submitted by <strong>{{ $requesterDisplayName !== '' ? $requesterDisplayName : 'an employee' }}</strong>.
                        </p>
                        <p style="margin:0 0 8px;font-size:15px;font-weight:600;color:#173A6B;">Request details</p>
                        <p style="margin:0 0 6px;font-size:15px;line-height:1.6;color:#334155;">Gate Pass No: {{ $gatepass->gatepass_no }}</p>
                        <p style="margin:0 0 6px;font-size:15px;line-height:1.6;color:#334155;">Request date: {{ optional($gatepass->request_date)->format('M j, Y') ?? '—' }}</p>
                        <p style="margin:0 0 6px;font-size:15px;line-height:1.6;color:#334155;">Center/Division: {{ $gatepass->center ?? '—' }}</p>
                        <p style="margin:0 0 6px;font-size:15px;line-height:1.6;color:#334155;">Destination: {{ $gatepass->destination ?? '—' }}</p>
                        <p style="margin:0 0 16px;font-size:15px;line-height:1.6;color:#334155;">Purpose: {{ $gatepass->purpose ?? '—' }}</p>
                        <p style="margin:0;font-size:14px;line-height:1.6;color:#64748b;">
                            Please review this request in the admin dashboard.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
