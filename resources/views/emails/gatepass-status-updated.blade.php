<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gate pass status — Development Academy of Philippines</title>
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
                            Hello {{ $recipientDisplayName !== '' ? $recipientDisplayName : 'there' }},
                        </p>
                        @php
                            $statusLower = strtolower($newStatus);
                            $isApproved = $statusLower === 'approved';
                            $isRejected = $statusLower === 'rejected';
                        @endphp
                        @if ($isApproved)
                            <p style="margin:0 0 16px;font-size:15px;line-height:1.6;color:#334155;">
                                Your gate pass request <strong>{{ $gatepass->gatepass_no }}</strong> has been <strong style="color:#00b84f;">approved</strong>.
                            </p>
                        @elseif ($isRejected)
                            <p style="margin:0 0 16px;font-size:15px;line-height:1.6;color:#334155;">
                                Your gate pass request <strong>{{ $gatepass->gatepass_no }}</strong> has been <strong style="color:#b91c1c;">rejected</strong>.
                            </p>
                        @else
                            <p style="margin:0 0 16px;font-size:15px;line-height:1.6;color:#334155;">
                                Your gate pass request <strong>{{ $gatepass->gatepass_no }}</strong> status is now <strong>{{ $newStatus }}</strong>.
                            </p>
                        @endif
                        <p style="margin:0 0 8px;font-size:15px;font-weight:600;color:#173A6B;">Request summary</p>
                        <p style="margin:0 0 6px;font-size:15px;line-height:1.6;color:#334155;">Request date: {{ optional($gatepass->request_date)->format('M j, Y') ?? '—' }}</p>
                        <p style="margin:0 0 6px;font-size:15px;line-height:1.6;color:#334155;">Destination: {{ $gatepass->destination ?? '—' }}</p>
                        <p style="margin:0 0 16px;font-size:15px;line-height:1.6;color:#334155;">Purpose: {{ $gatepass->purpose ?? '—' }}</p>
                        @if ($isRejected && filled($gatepass->rejection_reason))
                            <p style="margin:0 0 16px;font-size:15px;line-height:1.6;color:#334155;">
                                <span style="font-weight:600;color:#173A6B;">Reason:</span><br>
                                {{ $gatepass->rejection_reason }}
                            </p>
                        @endif
                        <p style="margin:0;font-size:14px;line-height:1.6;color:#64748b;">
                            You can review this request anytime on your employee dashboard.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
