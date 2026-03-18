<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\GatepassRequest;
use App\Models\GatepassRequestItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeGatepassRequestController extends Controller
{
    public function dashboard(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user === null) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 401);
        }

        /** @var Employee|null $employee */
        $employee = Employee::query()
            ->where('user_id', $user->id)
            ->first();

        if ($employee === null) {
            return response()->json([
                'message' => 'Employee record not found.',
            ], 422);
        }

        $status = (string) $request->query('status', 'All');
        $normalizedStatus = trim($status);

        $baseQuery = GatepassRequest::query()
            ->where('requester_employee_id', $employee->employee_id);

        $countsByStatus = (clone $baseQuery)
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $counts = [
            'total' => (int) $countsByStatus->sum(),
            'pending' => (int) ($countsByStatus['Pending'] ?? 0),
            'approved' => (int) ($countsByStatus['Approved'] ?? 0),
            'returned' => (int) ($countsByStatus['Returned'] ?? 0),
            'active_outside' => (int) ($countsByStatus['Active Outside'] ?? 0),
        ];

        $listQuery = (clone $baseQuery)
            ->with(['items.inventory:id,current_prop_no,description'])
            ->orderByDesc('request_date')
            ->orderByDesc('created_at');

        if ($normalizedStatus !== '' && strtolower($normalizedStatus) !== 'all') {
            $listQuery->where('status', $normalizedStatus);
        }

        $requests = $listQuery->limit(50)->get([
            'gatepass_no',
            'request_date',
            'status',
        ]);

        $rows = $requests->map(function (GatepassRequest $requestModel): array {
            return [
                'gatepass_no' => $requestModel->gatepass_no,
                'request_date' => optional($requestModel->request_date)->format('Y-m-d'),
                'status' => $requestModel->status,
                'equipments' => $requestModel->items
                    ->map(function ($item): array {
                        $inv = $item->inventory;

                        return [
                            'inventory_id' => $item->inventory_id,
                            'prop_no' => $inv?->current_prop_no,
                            'description' => $inv?->description,
                        ];
                    })
                    ->values()
                    ->all(),
            ];
        })->values();

        return response()->json([
            'data' => [
                'counts' => $counts,
                'requests' => $rows,
            ],
        ]);
    }

    public function history(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user === null) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 401);
        }

        /** @var Employee|null $employee */
        $employee = Employee::query()
            ->where('user_id', $user->id)
            ->first();

        if ($employee === null) {
            return response()->json([
                'message' => 'Employee record not found.',
            ], 422);
        }

        $requests = GatepassRequest::query()
            ->where('requester_employee_id', $employee->employee_id)
            ->with([
                'items.inventory:id,current_prop_no,description',
            ])
            ->orderByDesc('request_date')
            ->orderByDesc('created_at')
            ->get([
                'gatepass_no',
                'request_date',
                'status',
            ]);

        $payload = $requests->map(function (GatepassRequest $requestModel): array {
            return [
                'gatepass_no' => $requestModel->gatepass_no,
                'request_date' => optional($requestModel->request_date)->format('Y-m-d'),
                'status' => $requestModel->status,
                'equipments' => $requestModel->items
                    ->map(function ($item): array {
                        $inv = $item->inventory;

                        return [
                            'inventory_id' => $item->inventory_id,
                            'prop_no' => $inv?->current_prop_no,
                            'description' => $inv?->description,
                        ];
                    })
                    ->values()
                    ->all(),
            ];
        })->values();

        return response()->json([
            'data' => $payload,
        ]);
    }

    public function show(Request $request, string $gatepass_no): JsonResponse
    {
        $user = $request->user();

        if ($user === null) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 401);
        }

        /** @var Employee|null $employee */
        $employee = Employee::query()
            ->where('user_id', $user->id)
            ->first();

        if ($employee === null) {
            return response()->json([
                'message' => 'Employee record not found.',
            ], 422);
        }

        $requestModel = GatepassRequest::query()
            ->where('gatepass_no', $gatepass_no)
            ->where('requester_employee_id', $employee->employee_id)
            ->with(['items.inventory:id,current_prop_no,description'])
            ->first();

        if ($requestModel === null) {
            return response()->json([
                'message' => 'Request not found.',
            ], 404);
        }

        return response()->json([
            'data' => [
                'gatepass_no' => $requestModel->gatepass_no,
                'status' => $requestModel->status,
                'request_date' => optional($requestModel->request_date)->format('Y-m-d'),
                'purpose' => $requestModel->purpose,
                'destination' => $requestModel->destination,
                'remarks' => $requestModel->remarks,
                'items' => $requestModel->items
                    ->values()
                    ->map(function (GatepassRequestItem $item, int $idx): array {
                        return [
                            'order' => $idx + 1,
                            'inventory_id' => $item->inventory_id,
                            'prop_no' => $item->inventory?->current_prop_no,
                            'description' => $item->inventory?->description,
                        ];
                    })
                    ->all(),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user === null) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 401);
        }

        /** @var Employee|null $employee */
        $employee = Employee::query()
            ->where('user_id', $user->id)
            ->first();

        if ($employee === null) {
            return response()->json([
                'message' => 'Employee record not found.',
            ], 422);
        }

        $validated = $request->validate([
            'purpose' => ['required', 'string', 'max:255'],
            'destination' => ['required', 'string', 'max:255'],
            'remarks' => ['nullable', 'string', 'max:500'],
            'inventory_ids' => ['required', 'array', 'min:1'],
            'inventory_ids.*' => ['integer', 'exists:inventory,id'],
        ]);

        try {
            $gatepassRequest = DB::transaction(function () use ($validated, $employee) {
                $now = now();

                $requestModel = GatepassRequest::query()->create([
                    'gatepass_no' => GatepassRequest::generateGatepassNo(),
                    'request_date' => $now->toDateString(),
                    'requester_employee_id' => $employee->employee_id,
                    'center' => $employee->center,
                    'purpose' => $validated['purpose'],
                    'destination' => $validated['destination'],
                    'remarks' => $validated['remarks'] ?? null,
                    'status' => 'Pending',
                    'noted_by_employee_id' => null,
                    'authorized_by_employee_id' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                foreach ($validated['inventory_ids'] as $inventoryId) {
                    GatepassRequestItem::query()->create([
                        'gatepass_no' => $requestModel->gatepass_no,
                        'inventory_id' => $inventoryId,
                        'item_remarks' => null,
                    ]);
                }

                return $requestModel;
            });
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Failed to submit gate pass request. Please try again.',
            ], 500);
        }

        return response()->json([
            'message' => 'Gate pass request submitted successfully.',
            'data' => [
                'gatepass_no' => $gatepassRequest->gatepass_no,
            ],
        ], 201);
    }
}
