<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GuardGatepassLogController extends Controller
{
    public function next(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'gatepass_no' => ['required', 'string'],
            'requester_name' => ['nullable', 'string'],
        ]);

        $gatepassNo = $validated['gatepass_no'];

        $gatepass = DB::table('gatepass_requests')
            ->where('gatepass_no', $gatepassNo)
            ->first();

        if (!$gatepass) {
            return response()->json([
                'message' => 'Gatepass not found.',
            ], 404);
        }

        $requesterEmployeeId = $this->resolveRequesterEmployeeId(
            $gatepass,
            $validated['requester_name'] ?? null
        );

        if (!$requesterEmployeeId) {
            return response()->json([
                'message' => 'Requester employee record not found for this gatepass.',
            ], 422);
        }

        $lastLogType = DB::table('gatepass_logs')
            ->where('gatepass_no', $gatepassNo)
            ->orderByDesc('log_datetime')
            ->orderByDesc('log_id')
            ->value('log_type');

        $nextLogType = $this->resolveNextLogType($lastLogType);

        return response()->json([
            'gatepass_no' => $gatepassNo,
            'requester_employee_id' => $requesterEmployeeId,
            'log_type' => $nextLogType,
            'log_datetime' => now()->toDateTimeString(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'gatepass_no' => ['required', 'string'],
            'requester_name' => ['nullable', 'string'],
        ]);

        $guardUserId = $request->user()?->id;

        if (!$guardUserId) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 401);
        }

        $result = DB::transaction(function () use ($validated, $guardUserId) {
            $gatepassNo = $validated['gatepass_no'];

            // Lock gatepass row to prevent two requests from creating the same next log type.
            $gatepass = DB::table('gatepass_requests')
                ->where('gatepass_no', $gatepassNo)
                ->lockForUpdate()
                ->first();

            if (!$gatepass) {
                return [
                    'ok' => false,
                    'status' => 404,
                    'message' => 'Gatepass not found.',
                ];
            }

            $requesterEmployeeId = $this->resolveRequesterEmployeeId(
                $gatepass,
                $validated['requester_name'] ?? null
            );

            if (!$requesterEmployeeId) {
                return [
                    'ok' => false,
                    'status' => 422,
                    'message' => 'Requester employee record not found for this gatepass.',
                ];
            }

            $lastLog = DB::table('gatepass_logs')
                ->where('gatepass_no', $gatepassNo)
                ->orderByDesc('log_datetime')
                ->orderByDesc('log_id')
                ->lockForUpdate()
                ->first();

            $lastLogType = $lastLog?->log_type;
            $nextLogType = $this->resolveNextLogType($lastLogType);
            $now = now();

            DB::table('gatepass_logs')->insert([
                'gatepass_no' => $gatepassNo,
                'log_type' => $nextLogType,
                'scanned_by_guard_id' => $guardUserId,
                'requester_employee_id' => $requesterEmployeeId,
                'log_datetime' => $now->toDateTimeString(),
                'remarks' => null,
                'created_at' => $now->toDateTimeString(),
                'updated_at' => $now->toDateTimeString(),
            ]);

            return [
                'ok' => true,
                'status' => 201,
                'data' => [
                    'gatepass_no' => $gatepassNo,
                    'requester_employee_id' => $requesterEmployeeId,
                    'scanned_by_guard_id' => $guardUserId,
                    'log_type' => $nextLogType,
                    'log_datetime' => $now->toDateTimeString(),
                    'message' => "{$nextLogType} recorded successfully",
                ],
            ];
        });

        if (!$result['ok']) {
            return response()->json([
                'message' => $result['message'],
            ], $result['status']);
        }

        return response()->json($result['data'], $result['status']);
    }

    private function resolveNextLogType(?string $lastLogType): string
    {
        $last = Str::upper((string) $lastLogType);

        return match ($last) {
            'INCOMING' => 'OUTGOING',
            'OUTGOING' => 'INCOMING',
            default => 'OUTGOING',
        };
    }

    private function resolveRequesterEmployeeId(object $gatepass, ?string $requesterNameFromRequest = null): ?string
    {
        if (!empty($gatepass->requester_employee_id)) {
            return (string) $gatepass->requester_employee_id;
        }

        if (!empty($gatepass->employee_id)) {
            return (string) $gatepass->employee_id;
        }

        $requesterName = $requesterNameFromRequest;

        if (!$requesterName && !empty($gatepass->requester_name)) {
            $requesterName = $gatepass->requester_name;
        }

        if (!$requesterName && !empty($gatepass->requester)) {
            $requesterName = $gatepass->requester;
        }

        if (!$requesterName) {
            return null;
        }

        return Employee::query()
            ->where('employee_name', $requesterName)
            ->value('employee_id');
    }
}