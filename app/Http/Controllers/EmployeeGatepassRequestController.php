<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\GatepassRequest;
use App\Models\GatepassRequestItem;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Logo\Logo;
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
        $employee = Employee::resolveForGatepassUser($user);

        if ($employee === null) {
            return response()->json([
                'data' => [
                    'counts' => [
                        'total' => 0,
                        'pending' => 0,
                        'approved' => 0,
                        'returned' => 0,
                        'active_outside' => 0,
                        'incoming_partial' => 0,
                    ],
                    'requests' => [],
                ],
            ]);
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
            'incoming_partial' => (int) ($countsByStatus['Incoming Partial'] ?? 0),
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
        $employee = Employee::resolveForGatepassUser($user);

        if ($employee === null) {
            return response()->json([
                'data' => [],
            ]);
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

        /** @var Employee|null $employee */
        $employee = Employee::resolveForGatepassUser($request->user());

        if ($employee === null || $gatepass->requester_employee_id !== $employee->employee_id) {
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

    public function qrCode(string $gatepassNo)
    {
        $user = auth()->user();

        if ($user === null) {
            abort(401, 'Unauthorized.');
        }

        $employee = Employee::resolveForGatepassUser($user);

        if ($employee === null) {
            abort(403, 'Employee record not found.');
        }

        $requestModel = GatepassRequest::query()
            ->where('gatepass_no', $gatepassNo)
            ->where('requester_employee_id', $employee->employee_id)
            ->first();

        if ($requestModel === null) {
            abort(404, 'Gate pass request not found.');
        }

        if (strtolower((string) $requestModel->status) !== 'approved') {
            abort(403, 'QR code is only available for approved gate pass requests.');
        }

        $qrText = route('employee.gatepass-requests.show', [
            'gatepass_no' => $requestModel->gatepass_no,
        ]);

        $existingRelativePath = ! empty($requestModel->qr_code_path)
            ? ltrim((string) $requestModel->qr_code_path, '/')
            : null;

        if ($existingRelativePath !== null) {
            $existingAbsolutePath = Storage::disk('public')->path($existingRelativePath);

            if (is_file($existingAbsolutePath)) {
                $extension = strtolower(pathinfo($existingAbsolutePath, PATHINFO_EXTENSION));

                $mime = match ($extension) {
                    'svg' => 'image/svg+xml',
                    'png' => 'image/png',
                    default => mime_content_type($existingAbsolutePath) ?: 'application/octet-stream',
                };

                return response()->file($existingAbsolutePath, [
                    'Content-Type' => $mime,
                    'Cache-Control' => 'no-store, max-age=0',
                ]);
            }
        }

        try {
            $generated = $this->generateQrBinaryWithFallback($qrText, [
                'gatepass_no' => $requestModel->gatepass_no,
                'source' => 'employee.qrCode',
            ]);

            Storage::disk('public')->makeDirectory('gatepass_qr');

            $newRelativePath = 'gatepass_qr/'.$requestModel->gatepass_no.'.'.$generated['extension'];

            $stored = Storage::disk('public')->put($newRelativePath, $generated['binary']);

            if ($stored !== true) {
                Log::error('Failed to store gatepass QR code (employee)', [
                    'gatepass_no' => $requestModel->gatepass_no,
                    'relative_path' => $newRelativePath,
                    'disk' => 'public',
                ]);

                abort(500, 'Failed to save QR code.');
            }

            $requestModel->forceFill([
                'qr_code_path' => $newRelativePath,
                'qr_code_generated_at' => now(),
            ])->save();

            return response($generated['binary'], 200)
                ->header('Content-Type', $generated['mime'])
                ->header('Cache-Control', 'no-store, max-age=0');
        } catch (\Throwable $e) {
            Log::error('Failed to generate gatepass QR code (employee)', [
                'gatepass_no' => $requestModel->gatepass_no,
                'error' => $e->getMessage(),
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

        $logo = Logo::create(public_path('images/dap_logo.png'))
            ->setResizeToWidth(80);
        try {
            $result = Builder::create()
                ->writer(new PngWriter)
                ->data($qrText)
                ->size(320)
                ->logo($logo)
                ->errorCorrectionLevel(new ErrorCorrectionLevelHigh)
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
        $employee = Employee::resolveForGatepassUser($user);

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
                        'item_status' => null,
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
