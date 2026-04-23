<?php

namespace App\Services;

use App\Mail\GatepassStatusUpdatedMail;
use App\Models\GatepassRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class GatepassStatusEmailNotifier
{
    private const NOTIFIABLE_STATUSES = [
        'Approved',
        'Rejected',
        'Incoming Partial',
        'Returned',
    ];

    /**
     * Notify the employee linked to the gate pass (requester's `users` record) after a notifiable status change.
     */
    public function notifyRequester(GatepassRequest $gatepass): void
    {
        $status = (string) $gatepass->status;

        if (! in_array($status, self::NOTIFIABLE_STATUSES, true)) {
            return;
        }

        $gatepass->loadMissing(['requester.user']);

        $user = $gatepass->requester?->user;
        $email = $user?->email;

        if ($email === null || $email === '') {
            Log::warning('Gate pass status email skipped: requester has no user email.', [
                'gatepass_no' => $gatepass->gatepass_no,
            ]);

            return;
        }

        $displayName = (string) ($user->name ?? $gatepass->requester?->employee_name ?? '');

        try {
            Mail::to($email)->send(new GatepassStatusUpdatedMail(
                gatepass: $gatepass,
                newStatus: $status,
                recipientDisplayName: $displayName,
            ));
        } catch (\Throwable $e) {
            Log::error('Gate pass status email failed to send.', [
                'gatepass_no' => $gatepass->gatepass_no,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
