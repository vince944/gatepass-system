<?php

namespace App\Http\Controllers;

use App\Models\GatepassRequest;
use App\Models\GatepassRequestItem;
use App\Models\Inventory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminGatepassRequestController extends Controller
{
    public function index(Request $request): View
    {
        $equipment = Inventory::query()
            ->orderBy('current_prop_no')
            ->get();

        $pendingCount = GatepassRequest::query()
            ->where('status', 'Pending')
            ->count();

        $approvedCount = GatepassRequest::query()
            ->where('status', 'Approved')
            ->count();

        $activeOutsideCount = GatepassRequest::query()
            ->whereIn('status', ['Active Outside', 'Released Outside'])
            ->count();

        $totalCount = GatepassRequest::query()->count();

        $requests = GatepassRequest::query()
            ->with([
                'requester:employee_id,user_id,employee_name,center',
                'requester.user:id,name',
                'items.inventory:id,current_prop_no,description',
            ])
            ->orderByDesc('request_date')
            ->orderByDesc('created_at')
            ->get();

        $search = trim((string) $request->query('q', ''));
        $perPage = 10;

        $trackedItemsQuery = GatepassRequestItem::query()
            ->from('gatepass_items as gpi')
            ->join('gatepass_requests as gpr', 'gpr.gatepass_no', '=', 'gpi.gatepass_no')
            ->join('inventory as inv', 'inv.id', '=', 'gpi.inventory_id')
            ->leftJoin('employees as emp', 'emp.employee_id', '=', 'gpr.requester_employee_id')
            ->leftJoin('users as usr', 'usr.id', '=', 'emp.user_id')
            ->select([
                'gpi.gatepass_item_id as gatepass_item_id',
                'gpr.gatepass_no as gatepass_no',
                'inv.description as item_description',
                'inv.serial_no as serial_no',
                'inv.current_prop_no as property_number',
                'gpr.center as center',
                'gpr.destination as destination',
                'gpr.status as request_status',
                DB::raw('COALESCE(emp.employee_name, usr.name) as employee_full_name'),
            ])
            ->when($search !== '', function ($query) use ($search) {
                $like = '%'.$search.'%';
                $query->where(function ($q) use ($like) {
                    $q->where('gpr.gatepass_no', 'like', $like)
                        ->orWhere('inv.description', 'like', $like)
                        ->orWhere('inv.serial_no', 'like', $like)
                        ->orWhere('inv.current_prop_no', 'like', $like)
                        ->orWhere('emp.employee_name', 'like', $like)
                        ->orWhere('usr.name', 'like', $like);
                });
            })
            ->orderByDesc('gpr.request_date')
            ->orderByDesc('gpr.created_at')
            ->orderByDesc('gpi.gatepass_item_id');

        $trackedItems = $trackedItemsQuery
            ->paginate($perPage)
            ->appends([
                'tab' => 'items',
                'q' => $search !== '' ? $search : null,
            ]);

        return view('admin.dashboard', [
            'equipment' => $equipment,
            'requests' => $requests,
            'trackedItems' => $trackedItems,
            'trackedItemsSearch' => $search,
            'showItemTracking' => $request->query('tab') === 'items' || $search !== '',
            'counts' => [
                'pending' => $pendingCount,
                'approved' => $approvedCount,
                'active_outside' => $activeOutsideCount,
                'total' => $totalCount,
            ],
        ]);
    }

    public function show(Request $request, string $gatepassNo): JsonResponse
    {
        $gatepass = GatepassRequest::query()
            ->where('gatepass_no', $gatepassNo)
            ->with([
                'requester:employee_id,user_id,employee_name,center',
                'requester.user:id,name',
                'items.inventory:id,current_prop_no,description',
            ])
            ->first();

        if ($gatepass === null) {
            return response()->json([
                'message' => 'Gate pass request not found.',
            ], 404);
        }

        return response()->json([
            'data' => [
                'gatepass_no' => $gatepass->gatepass_no,
                'status' => $gatepass->status,
                'request_date' => optional($gatepass->request_date)->format('Y-m-d'),
                'purpose' => $gatepass->purpose,
                'destination' => $gatepass->destination,
                'remarks' => $gatepass->remarks,
                'items' => $gatepass->items
                    ->values()
                    ->map(function ($item, int $idx): array {
                        $inv = $item->inventory;

                        return [
                            'order' => $idx + 1,
                            'prop_no' => $inv?->current_prop_no,
                            'description' => $inv?->description,
                            'item_remarks' => $item->item_remarks,
                        ];
                    })
                    ->all(),
            ],
        ]);
    }

    public function approve(Request $request, string $gatepassNo): JsonResponse|RedirectResponse
    {
        return $this->updateStatus($request, $gatepassNo, 'Approved');
    }

    public function reject(Request $request, string $gatepassNo): JsonResponse|RedirectResponse
    {
        return $this->updateStatus($request, $gatepassNo, 'Rejected');
    }

    protected function updateStatus(Request $request, string $gatepassNo, string $status): JsonResponse|RedirectResponse
    {
        $result = DB::transaction(function () use ($gatepassNo, $status): array {
            $gatepass = GatepassRequest::query()
                ->where('gatepass_no', $gatepassNo)
                ->lockForUpdate()
                ->first();

            if ($gatepass === null) {
                return [
                    'ok' => false,
                    'code' => 404,
                    'message' => 'Gate pass request not found.',
                    'status' => null,
                ];
            }

            if ($gatepass->status === $status) {
                return [
                    'ok' => true,
                    'code' => 200,
                    'message' => "Request is already {$status}.",
                    'status' => $gatepass->status,
                ];
            }

            $gatepass->forceFill([
                'status' => $status,
            ])->save();

            return [
                'ok' => true,
                'code' => 200,
                'message' => "Request {$status} successfully.",
                'status' => $gatepass->status,
            ];
        });

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $result['message'],
                'data' => [
                    'status' => $result['status'],
                ],
            ], $result['code']);
        }

        return back()->with('success', $result['message']);
    }
}
