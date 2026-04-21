<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\GatepassRequest;
use App\Models\GatepassRequestItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GuardGatepassLogController extends Controller
{
    public const LOG_PARTIAL = 'PARTIAL';

    public const STATUS_INCOMING_PARTIAL = 'Incoming Partial';

    public const STATUS_RETURNED = 'Returned';

    public const ITEM_PENDING_RETURN = 'pending_return';

    public const ITEM_RETURNED = 'returned';

    public const ITEM_MISSING = 'missing';

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

        if (! $gatepass) {
            return response()->json([
                'message' => 'Gatepass not found.',
            ], 404);
        }

        $requesterEmployeeId = $this->resolveRequesterEmployeeId(
            $gatepass,
            $validated['requester_name'] ?? null
        );

        if (! $requesterEmployeeId) {
            return response()->json([
                'message' => 'Requester employee record not found for this gatepass.',
            ], 422);
        }

        $lastLogType = DB::table('gatepass_logs')
            ->where('gatepass_no', $gatepassNo)
            ->orderByDesc('log_datetime')
            ->orderByDesc('log_id')
            ->value('log_type');

        $isIncomingPartialStatus = strtolower((string) $gatepass->status) === strtolower(self::STATUS_INCOMING_PARTIAL);
        $nextLogType = $isIncomingPartialStatus
            ? self::LOG_PARTIAL
            : $this->resolveNextLogType($lastLogType);

        if ($nextLogType === 'INCOMING') {
            DB::table('gatepass_items')
                ->where('gatepass_no', $gatepassNo)
                ->update([
                    'item_status' => self::ITEM_PENDING_RETURN,
                    'returned_at' => null,
                    'updated_at' => now()->toDateTimeString(),
                ]);
        }

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
            'log_type' => ['required', 'string', 'in:OUTGOING,INCOMING'],
            'complete_partial' => ['nullable', 'boolean'],
        ]);

        $guardUserId = $request->user()?->id;

        if (! $guardUserId) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 401);
        }

        $result = DB::transaction(function () use ($validated, $guardUserId) {
            $gatepassNo = $validated['gatepass_no'];

            $gatepass = DB::table('gatepass_requests')
                ->where('gatepass_no', $gatepassNo)
                ->lockForUpdate()
                ->first();

            if (! $gatepass) {
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

            if (! $requesterEmployeeId) {
                return [
                    'ok' => false,
                    'status' => 422,
                    'message' => 'Requester employee record not found for this gatepass.',
                ];
            }

            $isIncomingPartialStatus = strtolower((string) $gatepass->status) === strtolower(self::STATUS_INCOMING_PARTIAL);
            $completePartial = (bool) ($validated['complete_partial'] ?? false);
            $nextLogType = strtoupper((string) $validated['log_type']);
            $now = now();

            if ($isIncomingPartialStatus && $nextLogType !== 'INCOMING') {
                return [
                    'ok' => false,
                    'status' => 422,
                    'message' => 'Incoming scan is required to complete a partial return.',
                ];
            }

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

            if ($nextLogType === 'INCOMING') {
                if ($isIncomingPartialStatus && $completePartial) {
                    DB::table('gatepass_items')
                        ->where('gatepass_no', $gatepassNo)
                        ->update([
                            'item_status' => self::ITEM_RETURNED,
                            'returned_at' => $now->toDateTimeString(),
                            'last_inspected_by' => $guardUserId,
                            'updated_at' => $now->toDateTimeString(),
                        ]);

                    DB::table('gatepass_requests')
                        ->where('gatepass_no', $gatepassNo)
                        ->update([
                            'status' => self::STATUS_RETURNED,
                            'incoming_inspection_remarks' => null,
                            'incoming_inspected_at' => $now->toDateTimeString(),
                            'incoming_inspected_by' => $guardUserId,
                            'updated_at' => $now->toDateTimeString(),
                        ]);
                } else {
                    DB::table('gatepass_items')
                        ->where('gatepass_no', $gatepassNo)
                        ->update([
                            'item_status' => self::ITEM_PENDING_RETURN,
                            'returned_at' => null,
                            'last_inspected_by' => $guardUserId,
                            'updated_at' => $now->toDateTimeString(),
                        ]);

                    DB::table('gatepass_requests')
                        ->where('gatepass_no', $gatepassNo)
                        ->update([
                            'status' => self::STATUS_RETURNED,
                            'incoming_inspection_remarks' => null,
                            'incoming_inspected_at' => $now->toDateTimeString(),
                            'incoming_inspected_by' => $guardUserId,
                            'updated_at' => $now->toDateTimeString(),
                        ]);
                }
            } elseif ($nextLogType === 'OUTGOING') {
                DB::table('gatepass_items')
                    ->where('gatepass_no', $gatepassNo)
                    ->update([
                        'item_status' => null,
                        'returned_at' => null,
                        'last_inspected_by' => null,
                        'updated_at' => $now->toDateTimeString(),
                    ]);

                DB::table('gatepass_requests')
                    ->where('gatepass_no', $gatepassNo)
                    ->update([
                        'status' => 'Approved',
                        'updated_at' => $now->toDateTimeString(),
                    ]);
            }

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
                    'gatepass_status' => $nextLogType === 'INCOMING'
                        ? self::STATUS_RETURNED
                        : null,
                ],
            ];
        });

        if (! $result['ok']) {
            return response()->json([
                'message' => $result['message'],
            ], $result['status']);
        }

        $payload = $result['data'];
        if ($payload['gatepass_status'] === null) {
            unset($payload['gatepass_status']);
        }

        return response()->json($payload, $result['status']);
    }

    public function items(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'gatepass_no' => ['required', 'string'],
        ]);

        $gatepass = GatepassRequest::query()
            ->with(['items.inventory:id,current_prop_no,description,serial_no'])
            ->where('gatepass_no', $validated['gatepass_no'])
            ->first();

        if (! $gatepass) {
            return response()->json(['message' => 'Gatepass not found.'], 404);
        }

        $lastLogType = DB::table('gatepass_logs')
            ->where('gatepass_no', $gatepass->gatepass_no)
            ->orderByDesc('log_datetime')
            ->orderByDesc('log_id')
            ->value('log_type');

        $nextLogType = $this->resolveNextLogType($lastLogType);
        $isOutgoingPhase = $nextLogType === 'OUTGOING';

        $items = $gatepass->items->map(function ($item) use ($isOutgoingPhase) {
            return [
                'gatepass_item_id' => $item->gatepass_item_id,
                'property_number' => $item->inventory?->current_prop_no ?? 'N/A',
                'description' => $item->inventory?->description ?? 'N/A',
                'serial_no' => $item->inventory?->serial_no ?? 'N/A',
                'remarks' => $item->item_remarks ?? 'N/A',
                'item_status' => $isOutgoingPhase ? null : $item->item_status,
                'returned_at' => optional($item->returned_at)->toDateTimeString(),
            ];
        })->values()->all();

        $displayStatus = $this->resolveDisplayStatus($gatepass->gatepass_no, (string) $gatepass->status);

        return response()->json([
            'gatepass_no' => $gatepass->gatepass_no,
            'gatepass_status' => $displayStatus,
            'items' => $items,
        ]);
    }

    public function history(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
            'search' => ['nullable', 'string', 'max:255'],
        ]);

        $page = (int) ($validated['page'] ?? 1);
        $perPage = (int) ($validated['per_page'] ?? 5);
        $search = trim((string) ($validated['search'] ?? ''));

        $baseQuery = DB::table('gatepass_logs as gl')
            ->leftJoin('gatepass_requests as gr', 'gr.gatepass_no', '=', 'gl.gatepass_no')
            ->leftJoin('employees as requester', 'requester.employee_id', '=', 'gl.requester_employee_id')
            ->leftJoin('users as guard_user', 'guard_user.id', '=', 'gl.scanned_by_guard_id')
            ->leftJoinSub(
                DB::table('gatepass_items as gi')
                    ->leftJoin('inventory as i', 'i.id', '=', 'gi.inventory_id')
                    ->select(
                        'gi.gatepass_no',
                        DB::raw("GROUP_CONCAT(DISTINCT COALESCE(NULLIF(i.description, ''), 'N/A') ORDER BY i.description SEPARATOR ', ') as equipment_type")
                    )
                    ->groupBy('gatepass_no'),
                'gi_counts',
                'gi_counts.gatepass_no',
                '=',
                'gl.gatepass_no'
            )
            ->whereIn('gl.log_type', ['INCOMING', 'OUTGOING']);

        if ($search !== '') {
            $searchLike = '%'.$search.'%';
            $baseQuery->where(function ($query) use ($searchLike) {
                $query
                    ->where('gl.gatepass_no', 'like', $searchLike)
                    ->orWhere('requester.employee_name', 'like', $searchLike)
                    ->orWhere('gl.requester_employee_id', 'like', $searchLike);
            });
        }

        $total = (clone $baseQuery)->count();
        $lastPage = max(1, (int) ceil($total / $perPage));
        $page = min($page, $lastPage);
        $offset = ($page - 1) * $perPage;

        $rows = $baseQuery
            ->orderByDesc('gl.log_datetime')
            ->orderByDesc('gl.log_id')
            ->offset($offset)
            ->limit($perPage)
            ->get([
                'gl.log_id',
                'gl.gatepass_no',
                'gl.log_type',
                'gl.log_datetime',
                'gl.requester_employee_id',
                'requester.employee_name as requester_name',
                'guard_user.name as scanned_by_guard_name',
                DB::raw("COALESCE(NULLIF(gi_counts.equipment_type, ''), 'N/A') as equipment_type"),
                'gr.status as gatepass_status',
                'gr.destination',
                'gr.purpose',
            ]);

        return response()->json([
            'records' => $rows,
            'meta' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'last_page' => $lastPage,
            ],
        ]);
    }

    public function partialReturn(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'gatepass_no' => ['required', 'string'],
            'missing_item_ids' => ['required', 'array', 'min:1'],
            'missing_item_ids.*' => ['required', 'integer'],
            'remarks' => ['nullable', 'string', 'max:2000'],
        ]);

        $guardUserId = $request->user()?->id;

        if (! $guardUserId) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        $result = DB::transaction(function () use ($validated, $guardUserId) {
            $gatepass = GatepassRequest::query()
                ->with(['items'])
                ->where('gatepass_no', $validated['gatepass_no'])
                ->lockForUpdate()
                ->first();

            if (! $gatepass) {
                return ['ok' => false, 'status' => 404, 'message' => 'Gatepass not found.'];
            }

            if (strtolower((string) $gatepass->status) === 'rejected') {
                return ['ok' => false, 'status' => 422, 'message' => 'This gatepass is rejected and cannot be updated.'];
            }

            $validItemIds = $gatepass->items->pluck('gatepass_item_id')->all();
            $missingIds = array_values(array_unique(array_intersect(
                array_map('intval', $validated['missing_item_ids']),
                array_map('intval', $validItemIds)
            )));

            if (empty($missingIds)) {
                return [
                    'ok' => false,
                    'status' => 422,
                    'message' => 'Please select valid item(s) from this gatepass.',
                ];
            }

            $now = now();
            $returnedIds = array_values(array_diff(
                array_map('intval', $validItemIds),
                $missingIds
            ));

            foreach ($returnedIds as $gatepassItemId) {
                GatepassRequestItem::query()
                    ->where('gatepass_item_id', $gatepassItemId)
                    ->where('gatepass_no', $gatepass->gatepass_no)
                    ->update([
                        'item_status' => self::ITEM_RETURNED,
                        'returned_at' => $now->toDateTimeString(),
                        'last_inspected_by' => $guardUserId,
                        'updated_at' => $now->toDateTimeString(),
                    ]);
            }

            foreach ($missingIds as $gatepassItemId) {
                GatepassRequestItem::query()
                    ->where('gatepass_item_id', $gatepassItemId)
                    ->where('gatepass_no', $gatepass->gatepass_no)
                    ->update([
                        'item_status' => self::ITEM_MISSING,
                        'returned_at' => null,
                        'last_inspected_by' => $guardUserId,
                        'updated_at' => $now->toDateTimeString(),
                    ]);
            }

            $gatepass->forceFill([
                'status' => self::STATUS_INCOMING_PARTIAL,
                'incoming_inspection_remarks' => $validated['remarks'] ?? null,
                'incoming_inspected_at' => $now,
                'incoming_inspected_by' => $guardUserId,
            ])->save();

            return [
                'ok' => true,
                'status' => 200,
                'message' => 'Partial return recorded.',
                'data' => [
                    'gatepass_status' => self::STATUS_INCOMING_PARTIAL,
                ],
            ];
        });

        if (! $result['ok']) {
            return response()->json(['message' => $result['message']], $result['status']);
        }

        return response()->json([
            'message' => $result['message'],
            ...$result['data'],
        ], $result['status']);
    }

    public function reject(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'gatepass_no' => ['required', 'string'],
            'rejection_reason' => ['required', 'string', 'max:2000'],
        ]);

        $guardUserId = $request->user()?->id;

        if (! $guardUserId) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        $result = DB::transaction(function () use ($validated) {
            $gatepass = GatepassRequest::query()
                ->where('gatepass_no', $validated['gatepass_no'])
                ->lockForUpdate()
                ->first();

            if (! $gatepass) {
                return ['ok' => false, 'status' => 404, 'message' => 'Gatepass not found.'];
            }

            $gatepass->forceFill([
                'status' => 'Rejected',
                'rejection_reason' => $validated['rejection_reason'],
            ])->save();

            return [
                'ok' => true,
                'status' => 200,
                'message' => 'Gatepass rejected successfully.',
                'data' => ['status' => 'Rejected'],
            ];
        });

        if (! $result['ok']) {
            return response()->json(['message' => $result['message']], $result['status']);
        }

        return response()->json([
            'message' => $result['message'],
            ...$result['data'],
        ], $result['status']);
    }

    private function resolveNextLogType(?string $lastLogType): string
    {
        $last = Str::upper((string) $lastLogType);

        return match ($last) {
            'INCOMING' => 'OUTGOING',
            'OUTGOING' => 'INCOMING',
            self::LOG_PARTIAL => 'OUTGOING',
            default => 'OUTGOING',
        };
    }

    private function resolveRequesterEmployeeId(object $gatepass, ?string $requesterNameFromRequest = null): ?string
    {
        if (! empty($gatepass->requester_employee_id)) {
            return (string) $gatepass->requester_employee_id;
        }

        if (! empty($gatepass->employee_id)) {
            return (string) $gatepass->employee_id;
        }

        $requesterName = $requesterNameFromRequest;

        if (! $requesterName && ! empty($gatepass->requester_name)) {
            $requesterName = $gatepass->requester_name;
        }

        if (! $requesterName && ! empty($gatepass->requester)) {
            $requesterName = $gatepass->requester;
        }

        if (! $requesterName) {
            return null;
        }

        return Employee::query()
            ->where('employee_name', $requesterName)
            ->value('employee_id');
    }

    private function resolveDisplayStatus(string $gatepassNo, string $currentStatus): string
    {
        if (strtolower($currentStatus) !== strtolower(self::STATUS_RETURNED)) {
            return $currentStatus;
        }

        $movementCounts = DB::table('gatepass_logs')
            ->where('gatepass_no', $gatepassNo)
            ->whereIn('log_type', ['OUTGOING', 'INCOMING'])
            ->selectRaw("SUM(CASE WHEN log_type = 'OUTGOING' THEN 1 ELSE 0 END) as outgoing_count")
            ->selectRaw("SUM(CASE WHEN log_type = 'INCOMING' THEN 1 ELSE 0 END) as incoming_count")
            ->first();

        $outgoingCount = (int) ($movementCounts?->outgoing_count ?? 0);
        $incomingCount = (int) ($movementCounts?->incoming_count ?? 0);
        $usageCount = min($outgoingCount, $incomingCount);

        if ($usageCount < 2) {
            return self::STATUS_RETURNED;
        }

        return self::STATUS_RETURNED." - number of times gatepass is used: {$usageCount}";
    }
}
