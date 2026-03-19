<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\GatepassRequest;
use App\Models\GatepassRequestItem;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
                'qr_code_path' => $gatepass->qr_code_path,
                'qr_code_url' => $gatepass->qr_code_path ? asset('storage/'.ltrim($gatepass->qr_code_path, '/')) : null,
                'items' => $gatepass->items
                    ->values()
                    ->map(function ($item, int $idx): array {
                        $inv = $item->inventory;

                        return [
                            'order' => $idx + 1,
                            'gatepass_item_id' => $item->gatepass_item_id,
                            'inventory_id' => $item->inventory_id,
                            'prop_no' => $inv?->current_prop_no,
                            'description' => $inv?->description,
                            'serial_no' => $inv?->serial_no,
                            'item_remarks' => $item->item_remarks,
                        ];
                    })
                    ->all(),
            ],
        ]);
    }

    public function qrCode(Request $request, string $gatepass_no)
    {
        $user = $request->user();

        if ($user === null) {
            abort(401);
        }

        /** @var Employee|null $employee */
        $employee = Employee::query()
            ->where('user_id', $user->id)
            ->first();

        if ($employee === null) {
            abort(422, 'Employee record not found.');
        }

        $requestModel = GatepassRequest::query()
            ->where('gatepass_no', $gatepass_no)
            ->where('requester_employee_id', $employee->employee_id)
            ->with([
                'requester:employee_id,user_id,employee_name,center',
                'requester.user:id,name',
                'items.inventory:id,current_prop_no,description,serial_no',
            ])
            ->first([
                'gatepass_no',
                'status',
                'request_date',
                'center',
                'purpose',
                'destination',
                'remarks',
                'qr_code_path',
            ]);

        if ($requestModel === null) {
            abort(404, 'Request not found.');
        }

        if (strtolower((string) $requestModel->status) !== 'approved') {
            abort(404, 'QR code not found.');
        }

        $relativePath = ! empty($requestModel->qr_code_path)
            ? (string) $requestModel->qr_code_path
            : 'gatepass_qr/'.$requestModel->gatepass_no.'.png';

        $absolutePath = Storage::disk('public')->path($relativePath);

        if (! empty($requestModel->qr_code_path) && is_file($absolutePath)) {
            return response()->file($absolutePath, [
                'Content-Type' => 'image/png',
                'Cache-Control' => 'no-store, max-age=0',
            ]);
        }

        $qrPayload = [
            'gatepass_no' => $requestModel->gatepass_no,
            'request_date' => optional($requestModel->request_date)->format('Y-m-d'),
            'requester_name' => $requestModel->requester?->employee_name ?? $requestModel->requester?->user?->name ?? '—',
            'center_office' => $requestModel->center,
            'purpose' => $requestModel->purpose,
            'destination' => $requestModel->destination,
            'status' => $requestModel->status,
            'remarks' => $requestModel->remarks,
            'items' => $requestModel->items
                ->values()
                ->map(function (GatepassRequestItem $item, int $idx): array {
                    return [
                        'property_number' => $item->inventory?->current_prop_no,
                        'item_description' => $item->inventory?->description,
                        'serial_number' => $item->inventory?->serial_no,
                        'item_remarks' => $item->item_remarks,
                        'order' => $idx + 1,
                        'inventory_id' => $item->inventory_id,
                        'gatepass_item_id' => $item->gatepass_item_id,
                    ];
                })
                ->all(),
        ];

        try {
            $qrText = json_encode($qrPayload, JSON_UNESCAPED_UNICODE);
            if ($qrText === false || $qrText === '') {
                abort(500, 'Failed to generate QR payload.');
            }

            $generated = $this->generateQrBinaryWithFallback($qrText, [
                'gatepass_no' => $requestModel->gatepass_no,
                'source' => 'employee.qrCode',
            ]);

            Storage::disk('public')->makeDirectory('gatepass_qr');

            $stored = Storage::disk('public')->put($relativePath, $generated['binary']);
            if ($stored !== true) {
                Log::error('Failed to store gatepass QR code (employee)', [
                    'gatepass_no' => $requestModel->gatepass_no,
                    'relative_path' => $relativePath,
                    'disk' => 'public',
                ]);
            }

            $requestModel->forceFill([
                'qr_code_path' => $relativePath,
                'qr_code_generated_at' => now(),
            ])->save();

            return response($generated['binary'], 200)
                ->header('Content-Type', $generated['mime'])
                ->header('Cache-Control', 'no-store, max-age=0');
        } catch (\Throwable $e) {
            Log::error('Failed to generate gatepass QR code (employee)', [
                'gatepass_no' => $requestModel->gatepass_no ?? $gatepass_no,
                'error' => $e->getMessage(),
                'exception' => $e,
            ]);

            abort(500, 'Unable to generate QR code right now. Please try again later.');
        }
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
                ->margin(2)
                ->build();

            return [
                'binary' => $result->getString(),
                'mime' => 'image/png',
                'extension' => 'png',
            ];
        } catch (\Throwable $e) {
            Log::warning('PNG QR generation failed; attempting SVG fallback (employee)', [
                ...$context,
                'qr_text_length' => $qrTextLength,
                'error' => $e->getMessage(),
                'exception' => $e,
            ]);
        }

        try {
            $result = Builder::create()
                ->writer(new SvgWriter)
                ->data($qrText)
                ->size(320)
                ->margin(2)
                ->build();

            return [
                'binary' => $result->getString(),
                'mime' => 'image/svg+xml',
                'extension' => 'svg',
            ];
        } catch (\Throwable $e) {
            Log::error('SVG QR generation failed after PNG failure (employee)', [
                ...$context,
                'qr_text_length' => $qrTextLength,
                'error' => $e->getMessage(),
                'exception' => $e,
            ]);
        }

        throw new \RuntimeException('Unable to generate QR code.');
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
