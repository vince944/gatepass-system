<?php

namespace App\Http\Controllers;

use App\Models\GatepassRequest;
use App\Models\GatepassRequestItem;
use App\Models\Inventory;
use Carbon\Carbon;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
        $perPage = 5;

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

        $movementTracking = $this->getMovementTrackingStats();
        $gatepassTrendsByFilter = $this->getGatepassTrendsByFilter();

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
            'movementTracking' => $movementTracking,
            'gatepassTrendsByFilter' => $gatepassTrendsByFilter,
        ]);
    }

    public function show(Request $request, string $gatepassNo): JsonResponse
    {
        $gatepass = GatepassRequest::query()
            ->where('gatepass_no', $gatepassNo)
            ->with([
                'requester:employee_id,user_id,employee_name,center',
                'requester.user:id,name',
                'items.inventory:id,current_prop_no,description,serial_no',
            ])
            ->first();

        if ($gatepass === null) {
            return response()->json([
                'message' => 'Gate pass request not found.',
            ], 404);
        }

        $formatDateTime = static function ($value): ?string {
            if ($value === null || $value === '') {
                return null;
            }

            try {
                return Carbon::parse($value)->format('Y-m-d H:i:s');
            } catch (\Throwable) {
                return (string) $value;
            }
        };

        $inventoryIds = $gatepass->items
            ?->pluck('inventory_id')
            ->filter()
            ->unique()
            ->values()
            ->all() ?? [];

        $propNoHistoryRowsByInventory = collect();
        $remarksHistoryRowsByInventory = collect();
        $endUserHistoryRowsByInventory = collect();
        $unitCostHistoryRowsByInventory = collect();

        if (! empty($inventoryIds)) {
            $propNoHistoryRowsByInventory = DB::table('inventory_propno_history')
                ->whereIn('inventory_id', $inventoryIds)
                ->select(['inventory_id', 'prop_no', 'is_current', 'changed_at', 'created_at'])
                ->orderBy('created_at')
                ->get()
                ->groupBy('inventory_id');

            $remarksHistoryRowsByInventory = DB::table('inventory_remarks_history')
                ->whereIn('inventory_id', $inventoryIds)
                ->select(['inventory_id', 'remark_text', 'created_at'])
                ->orderBy('created_at')
                ->get()
                ->groupBy('inventory_id');

            $endUserHistoryRowsByInventory = DB::table('inventory_end_user_history')
                ->whereIn('inventory_id', $inventoryIds)
                ->select(['inventory_id', 'end_user', 'created_at'])
                ->orderBy('created_at')
                ->get()
                ->groupBy('inventory_id');

            $unitCostHistoryRowsByInventory = DB::table('inventory_unit_cost_history')
                ->whereIn('inventory_id', $inventoryIds)
                ->select(['inventory_id', 'unit_cost', 'created_at'])
                ->orderBy('created_at')
                ->get()
                ->groupBy('inventory_id');
        }

        $incomingOutgoingHistory = DB::table('gatepass_logs as gl')
            ->leftJoin('employees as guardEmp', 'guardEmp.user_id', '=', 'gl.scanned_by_guard_id')
            ->leftJoin('employees as reqEmp', 'reqEmp.employee_id', '=', 'gl.requester_employee_id')
            ->where('gl.gatepass_no', $gatepassNo)
            ->whereIn('gl.log_type', ['INCOMING', 'OUTGOING'])
            ->orderBy('gl.log_datetime')
            ->orderBy('gl.log_id')
            ->get([
                'gl.log_type',
                'gl.log_datetime',
                'gl.remarks',
                'gl.scanned_by_guard_id',
                'gl.requester_employee_id',
                'guardEmp.employee_id as guard_employee_id',
                'guardEmp.employee_name as guard_name',
                'reqEmp.employee_name as requester_name',
            ])
            ->map(static function ($row) use ($formatDateTime): array {
                return [
                    'log_type' => (string) $row->log_type,
                    'log_datetime' => $formatDateTime($row->log_datetime),
                    'remarks' => $row->remarks,
                    'scanned_by_guard_id' => $row->scanned_by_guard_id,
                    'guard_employee_id' => $row->guard_employee_id,
                    'requester_employee_id' => $row->requester_employee_id,
                    'guard_name' => $row->guard_name,
                    'requester_name' => $row->requester_name,
                ];
            })
            ->values()
            ->all();

        $isRejected = strtolower((string) $gatepass->status) === 'rejected';
        // Admin reject uses updateStatus() and does not send rejection_reason, while guard reject requires it.
        $rejectedByGuard = $isRejected && ! empty($gatepass->rejection_reason);
        $rejectedByGuardName = null;

        if ($rejectedByGuard) {
            $rejectedByGuardName = DB::table('gatepass_logs as gl')
                ->leftJoin('employees as guardEmp', 'guardEmp.user_id', '=', 'gl.scanned_by_guard_id')
                ->where('gl.gatepass_no', $gatepassNo)
                ->orderBy('gl.log_datetime', 'desc')
                ->orderBy('gl.log_id', 'desc')
                ->value('guardEmp.employee_name');

            if (empty($rejectedByGuardName) && ! empty($gatepass->incoming_inspected_by)) {
                $rejectedByGuardName = DB::table('employees')
                    ->where('user_id', $gatepass->incoming_inspected_by)
                    ->value('employee_name');
            }
        }

        return response()->json([
            'data' => [
                'gatepass_no' => $gatepass->gatepass_no,
                'status' => $gatepass->status,
                'request_date' => optional($gatepass->request_date)->format('Y-m-d'),
                'center' => $gatepass->center,
                'requester_name' => $gatepass->requester?->employee_name ?? $gatepass->requester?->user?->name ?? '—',
                'purpose' => $gatepass->purpose,
                'destination' => $gatepass->destination,
                'remarks' => $gatepass->remarks,
                'rejection_reason' => $gatepass->rejection_reason,
                'rejected_by_guard' => $rejectedByGuard,
                'rejected_by_guard_name' => $rejectedByGuardName,
                'incoming_outgoing_history' => $incomingOutgoingHistory,
                'items' => $gatepass->items
                    ->values()
                    ->map(function ($item, int $idx) use (
                        $propNoHistoryRowsByInventory,
                        $remarksHistoryRowsByInventory,
                        $endUserHistoryRowsByInventory,
                        $unitCostHistoryRowsByInventory,
                        $formatDateTime
                    ): array {
                        $inv = $item->inventory;
                        $inventoryId = $item->inventory_id;

                        $propNoHistory = ($propNoHistoryRowsByInventory->get($inventoryId) ?? collect())
                            ->map(static function ($row) use ($formatDateTime): array {
                                return [
                                    'prop_no' => $row->prop_no,
                                    'changed_at' => $formatDateTime($row->changed_at),
                                    'is_current' => (bool) $row->is_current,
                                    'created_at' => $formatDateTime($row->created_at),
                                ];
                            })
                            ->values()
                            ->all();

                        $remarksHistory = ($remarksHistoryRowsByInventory->get($inventoryId) ?? collect())
                            ->map(static function ($row) use ($formatDateTime): array {
                                return [
                                    'remark_text' => $row->remark_text,
                                    'created_at' => $formatDateTime($row->created_at),
                                ];
                            })
                            ->values()
                            ->all();

                        $endUserHistory = ($endUserHistoryRowsByInventory->get($inventoryId) ?? collect())
                            ->map(static function ($row) use ($formatDateTime): array {
                                return [
                                    'end_user' => $row->end_user,
                                    'created_at' => $formatDateTime($row->created_at),
                                ];
                            })
                            ->values()
                            ->all();

                        $unitCostHistory = ($unitCostHistoryRowsByInventory->get($inventoryId) ?? collect())
                            ->map(static function ($row) use ($formatDateTime): array {
                                return [
                                    'unit_cost' => $row->unit_cost,
                                    'created_at' => $formatDateTime($row->created_at),
                                ];
                            })
                            ->values()
                            ->all();

                        return [
                            'order' => $idx + 1,
                            'gatepass_item_id' => $item->gatepass_item_id,
                            'inventory_id' => $item->inventory_id,
                            'prop_no' => $inv?->current_prop_no,
                            'description' => $inv?->description,
                            'serial_no' => $inv?->serial_no,
                            'item_remarks' => $item->item_remarks,
                            'equipment_history' => [
                                'prop_no_history' => $propNoHistory,
                                'remarks_history' => $remarksHistory,
                                'end_user_history' => $endUserHistory,
                                'unit_cost_history' => $unitCostHistory,
                            ],
                        ];
                    })
                    ->all(),
            ],
        ]);
    }

    public function storeQrCode(Request $request, string $gatepassNo): JsonResponse
    {
        $validated = $request->validate([
            'qr_payload' => ['nullable', 'array'],
            'qr_image_data_url' => ['nullable', 'string', 'min:50'],
        ]);

        $qrPayload = $validated['qr_payload'] ?? null;
        $qrImageDataUrl = $validated['qr_image_data_url'] ?? null;

        if ($qrPayload === null && $qrImageDataUrl === null) {
            return response()->json(['message' => 'Either qr_payload or qr_image_data_url is required.'], 422);
        }

        $gatepass = GatepassRequest::query()
            ->where('gatepass_no', $gatepassNo)
            ->first(['gatepass_no', 'status', 'qr_code_path']);

        if ($gatepass === null) {
            return response()->json(['message' => 'Gate pass request not found.'], 404);
        }

        if (strtolower((string) $gatepass->status) !== 'approved') {
            return response()->json(['message' => 'QR code can only be saved for approved requests.'], 422);
        }

        if (! empty($gatepass->qr_code_path)) {
            return response()->json([
                'message' => 'QR code already exists.',
                'data' => [
                    'qr_code_path' => $gatepass->qr_code_path,
                    'qr_code_url' => Storage::url($gatepass->qr_code_path),
                ],
            ], 200);
        }

        $binary = null;
        $extension = 'png';
        $mime = 'image/png';

        if ($qrPayload !== null) {
            try {
                $qrText = json_encode($qrPayload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

                if ($qrText === false || $qrText === '') {
                    return response()->json(['message' => 'Invalid qr_payload provided.'], 422);
                }

                $generated = $this->generateQrBinaryWithFallback($qrText, [
                    'gatepass_no' => $gatepassNo,
                    'source' => 'admin.storeQrCode.payload',
                ]);

                $binary = $generated['binary'];
                $extension = $generated['extension'];
                $mime = $generated['mime'];
            } catch (\Throwable $e) {
                Log::error('Failed to generate gatepass QR code (admin)', [
                    'gatepass_no' => $gatepassNo,
                    'error' => $e->getMessage(),
                ]);

                return response()->json([
                    'message' => 'Unable to generate QR code right now. Please try again later.',
                ], 500);
            }
        } else {
            if (! is_string($qrImageDataUrl) || ! str_starts_with($qrImageDataUrl, 'data:image/png;base64,')) {
                return response()->json(['message' => 'Invalid QR image data URL.'], 422);
            }

            $base64 = substr($qrImageDataUrl, strlen('data:image/png;base64,'));
            $decoded = base64_decode($base64, true);

            if ($decoded === false || $decoded === '') {
                return response()->json(['message' => 'Failed to decode QR image.'], 422);
            }

            $binary = $decoded;
            $extension = 'png';
            $mime = 'image/png';
        }

        Storage::disk('public')->makeDirectory('gatepass_qr');

        $relativePath = 'gatepass_qr/'.$gatepassNo.'.'.$extension;
        $stored = Storage::disk('public')->put($relativePath, $binary);

        if ($stored !== true) {
            Log::error('Failed to store gatepass QR code (admin)', [
                'gatepass_no' => $gatepassNo,
                'relative_path' => $relativePath,
                'disk' => 'public',
            ]);

            return response()->json([
                'message' => 'Unable to save QR code right now. Please try again later.',
            ], 500);
        }

        $gatepass->forceFill([
            'qr_code_path' => $relativePath,
            'qr_code_generated_at' => now(),
        ])->save();

        return response()->json([
            'message' => 'QR code saved successfully.',
            'data' => [
                'qr_code_path' => $gatepass->qr_code_path,
                'qr_code_url' => Storage::url($gatepass->qr_code_path),
                'mime' => $mime,
            ],
        ]);
    }

    /**
     * @throws \RuntimeException
     */
    private function generateQrBinaryWithFallback(string $qrText, array $context = []): array
    {
        if (! class_exists(Builder::class)) {
            throw new \RuntimeException('QR library is not available.');
        }

        $qrTextLength = strlen($qrText);

        try {
            $result = Builder::create()
                ->writer(new PngWriter)
                ->data($qrText)
                ->size(320)
                ->margin(10)
                ->build();

            return [
                'binary' => $result->getString(),
                'mime' => 'image/png',
                'extension' => 'png',
            ];
        } catch (\Throwable $e) {
            Log::warning('PNG QR generation failed; attempting SVG fallback (admin)', [
                ...$context,
                'qr_text_length' => $qrTextLength,
                'error' => $e->getMessage(),
            ]);
        }

        try {
            $result = Builder::create()
                ->writer(new SvgWriter)
                ->data($qrText)
                ->size(320)
                ->margin(10)
                ->build();

            return [
                'binary' => $result->getString(),
                'mime' => 'image/svg+xml',
                'extension' => 'svg',
            ];
        } catch (\Throwable $e) {
            Log::error('SVG QR generation failed after PNG failure (admin)', [
                ...$context,
                'qr_text_length' => $qrTextLength,
                'error' => $e->getMessage(),
            ]);
        }

        throw new \RuntimeException('Unable to generate QR code.');
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

            if ($status === 'Approved' && empty($gatepass->qr_code_path)) {
                try {
                    $gatepass->loadMissing([
                        'requester:employee_id,user_id,employee_name,center',
                        'requester.user:id,name',
                        'items.inventory:id,current_prop_no,description,serial_no',
                    ]);

                    $qrPayload = [
                        'gatepass_no' => $gatepass->gatepass_no,
                        'status' => $gatepass->status,
                        'request_date' => optional($gatepass->request_date)->format('Y-m-d'),
                        'requester_name' => $gatepass->requester?->employee_name
                            ?? $gatepass->requester?->user?->name
                            ?? '—',
                        'center' => $gatepass->center,
                        'purpose' => $gatepass->purpose,
                        'destination' => $gatepass->destination,
                        'remarks' => $gatepass->remarks,
                        'items' => $gatepass->items->map(function ($item) {
                            return [
                                'property_number' => $item->inventory?->current_prop_no,
                                'description' => $item->inventory?->description,
                                'serial_no' => $item->inventory?->serial_no,
                                'item_remarks' => $item->item_remarks,
                            ];
                        })->values()->all(),
                    ];

                    $qrText = json_encode($qrPayload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

                    if ($qrText === false || $qrText === '') {
                        throw new \RuntimeException('Failed to encode QR payload.');
                    }

                    $generated = $this->generateQrBinaryWithFallback($qrText, [
                        'gatepass_no' => $gatepass->gatepass_no,
                        'source' => 'admin.updateStatus.approved',
                    ]);

                    Storage::disk('public')->makeDirectory('gatepass_qr');

                    $relativePath = 'gatepass_qr/'.$gatepass->gatepass_no.'.'.$generated['extension'];

                    $stored = Storage::disk('public')->put($relativePath, $generated['binary']);

                    if ($stored !== true) {
                        throw new \RuntimeException('Storage::put returned false.');
                    }

                    $gatepass->forceFill([
                        'qr_code_path' => $relativePath,
                        'qr_code_generated_at' => now(),
                    ])->save();

                    Log::info('QR code generated successfully.', [
                        'gatepass_no' => $gatepass->gatepass_no,
                        'path' => $relativePath,
                    ]);
                } catch (\Throwable $e) {
                    Log::error('QR auto-generation failed after approval.', [
                        'gatepass_no' => $gatepass->gatepass_no,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                }
            }

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

    private function getMovementTrackingStats(): array
    {
        $row = DB::table('gatepass_logs')
            ->selectRaw("
                SUM(CASE WHEN log_type = 'INCOMING' THEN 1 ELSE 0 END) as incoming_count,
                SUM(CASE WHEN log_type = 'OUTGOING' THEN 1 ELSE 0 END) as outgoing_count,
                COUNT(*) as total_movements
            ")
            ->first();

        $incoming = (int) ($row?->incoming_count ?? 0);
        $outgoing = (int) ($row?->outgoing_count ?? 0);
        $total = (int) ($row?->total_movements ?? ($incoming + $outgoing));

        return [
            'incoming_count' => $incoming,
            'outgoing_count' => $outgoing,
            'total_movements' => $total,
        ];
    }

    private function getGatepassTrendsByFilter(): array
    {
        return [
            'daily' => $this->gatepassTrendsForFilter('daily'),
            'weekly' => $this->gatepassTrendsForFilter('weekly'),
            'monthly' => $this->gatepassTrendsForFilter('monthly'),
            'quarterly' => $this->gatepassTrendsForFilter('quarterly'),
            'yearly' => $this->gatepassTrendsForFilter('yearly'),
        ];
    }

    /**
     * @return array{labels: string[], total: int[], approved: int[], rejected: int[], pending: int[], active_outside: int[]}
     */
    private function gatepassTrendsForFilter(string $filterType): array
    {
        $now = Carbon::now();

        $labels = [];
        $periodKeys = [];
        $fromDate = null;
        $periodExpr = null;
        $orderBy = null;

        $activeOutsideStatuses = ['Active Outside', 'Released Outside'];

        switch ($filterType) {
            case 'daily':
                $fromDate = $now->copy()->startOfDay()->subDays(6);
                $periodExpr = "DATE_FORMAT(request_date, '%Y-%m-%d')";
                $orderBy = 'period_key';
                for ($i = 0; $i < 7; $i++) {
                    $d = $fromDate->copy()->addDays($i);
                    $periodKey = $d->format('Y-m-d');
                    $periodKeys[] = $periodKey;
                    $labels[] = $d->format('M d');
                }
                break;

            case 'weekly':
                $fromDate = $now->copy()->startOfWeek(Carbon::MONDAY)->subWeeks(7);
                // ISO week key, matches YEARWEEK(date, 1).
                $periodExpr = 'YEARWEEK(request_date, 1)';
                $orderBy = 'period_key';
                for ($i = 0; $i < 8; $i++) {
                    $d = $fromDate->copy()->addWeeks($i);
                    $isoYear = $d->isoWeekYear;
                    $isoWeek = $d->isoWeek;
                    $periodKey = (string) (($isoYear * 100) + $isoWeek);
                    $periodKeys[] = $periodKey;
                    $labels[] = $isoYear.'-W'.str_pad((string) $isoWeek, 2, '0', STR_PAD_LEFT);
                }
                break;

            case 'monthly':
                $fromDate = $now->copy()->startOfMonth()->subMonths(5);
                $periodExpr = "DATE_FORMAT(request_date, '%Y-%m')";
                $orderBy = 'period_key';
                for ($i = 0; $i < 6; $i++) {
                    $d = $fromDate->copy()->addMonths($i);
                    $periodKey = $d->format('Y-m');
                    $periodKeys[] = $periodKey;
                    $labels[] = $d->format('M Y');
                }
                break;

            case 'quarterly':
                $fromDate = $now->copy()->startOfQuarter()->subQuarters(5);
                $periodExpr = "CONCAT(YEAR(request_date), '-Q', QUARTER(request_date))";
                $orderBy = 'period_key';
                for ($i = 0; $i < 6; $i++) {
                    $d = $fromDate->copy()->addQuarters($i);
                    $quarter = $d->quarter;
                    $periodKey = $d->year.'-Q'.$quarter;
                    $periodKeys[] = $periodKey;
                    $labels[] = 'Q'.$quarter.' '.$d->year;
                }
                break;

            case 'yearly':
                $fromDate = $now->copy()->startOfYear()->subYears(4);
                $periodExpr = 'YEAR(request_date)';
                $orderBy = 'period_key';
                for ($i = 0; $i < 5; $i++) {
                    $d = $fromDate->copy()->addYears($i);
                    $periodKey = (string) $d->year;
                    $periodKeys[] = $periodKey;
                    $labels[] = (string) $d->year;
                }
                break;

            default:
                $fromDate = $now->copy()->startOfDay()->subDays(6);
                $periodExpr = "DATE_FORMAT(request_date, '%Y-%m-%d')";
                $orderBy = 'period_key';
                $periodKeys[] = $fromDate->format('Y-m-d');
                $labels[] = $fromDate->format('M d');
                break;
        }

        $fromDateStr = $fromDate?->format('Y-m-d');

        $rows = DB::table('gatepass_requests')
            ->selectRaw("$periodExpr as period_key")
            ->selectRaw('COUNT(*) as total_requests')
            ->selectRaw("SUM(CASE WHEN status = 'Approved' THEN 1 ELSE 0 END) as approved")
            ->selectRaw("SUM(CASE WHEN status = 'Rejected' THEN 1 ELSE 0 END) as rejected")
            ->selectRaw("SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending")
            ->selectRaw('SUM(CASE WHEN status IN ('.implode(',', array_fill(0, count($activeOutsideStatuses), '?')).') THEN 1 ELSE 0 END) as active_outside', $activeOutsideStatuses)
            ->whereDate('request_date', '>=', $fromDateStr)
            ->groupBy('period_key')
            ->orderBy($orderBy)
            ->get();

        $map = [];
        foreach ($rows as $r) {
            $map[(string) $r->period_key] = [
                'total' => (int) ($r->total_requests ?? 0),
                'approved' => (int) ($r->approved ?? 0),
                'rejected' => (int) ($r->rejected ?? 0),
                'pending' => (int) ($r->pending ?? 0),
                'active_outside' => (int) ($r->active_outside ?? 0),
            ];
        }

        $total = [];
        $approved = [];
        $rejected = [];
        $pending = [];
        $activeOutside = [];

        foreach ($periodKeys as $key) {
            $vals = $map[$key] ?? [
                'total' => 0,
                'approved' => 0,
                'rejected' => 0,
                'pending' => 0,
                'active_outside' => 0,
            ];

            $total[] = $vals['total'];
            $approved[] = $vals['approved'];
            $rejected[] = $vals['rejected'];
            $pending[] = $vals['pending'];
            $activeOutside[] = $vals['active_outside'];
        }

        // Ensure we always return at least one bar so Chart.js renders.
        if (count($labels) === 0) {
            return [
                'labels' => ['No data'],
                'total' => [0],
                'approved' => [0],
                'rejected' => [0],
                'pending' => [0],
                'active_outside' => [0],
            ];
        }

        return [
            'labels' => $labels,
            'total' => $total,
            'approved' => $approved,
            'rejected' => $rejected,
            'pending' => $pending,
            'active_outside' => $activeOutside,
        ];
    }
}
