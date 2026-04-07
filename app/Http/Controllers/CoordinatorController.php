<?php

namespace App\Http\Controllers;

use App\Mail\EmployeeInvitationMail;
use App\Models\Employee;
use App\Models\GatepassRequest;
use App\Models\Inventory;
use App\Models\InventoryEndUserHistory;
use App\Models\InventoryPropNoHistory;
use App\Models\InventoryRemarksHistory;
use App\Models\InventoryUnitCostHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CoordinatorController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $accountableCount = Inventory::query()
            ->whereNotNull('employee_id')
            ->count();

        $unaccountableCount = Inventory::query()
            ->whereNull('employee_id')
            ->count();

        $totalCount = Inventory::query()->count();

        $baseDashboardQuery = Inventory::query()
            ->with(['employee', 'currentPropNo', 'currentUnitCost', 'currentEndUser', 'currentRemarks'])
            ->orderBy(
                InventoryPropNoHistory::query()
                    ->select('prop_no')
                    ->whereColumn('inventory_id', 'inventory.id')
                    ->latest()
                    ->limit(1)
            );

        $dashboardAccountableItems = (clone $baseDashboardQuery)
            ->whereNotNull('employee_id')
            ->get();

        $dashboardUnaccountableItems = (clone $baseDashboardQuery)
            ->whereNull('employee_id')
            ->get();

        $dashboardTotalItems = (clone $baseDashboardQuery)->get();
        $dashboardTrackerMovements = $this->getDashboardTrackerMovements();

        $employees = Employee::with('user')
            ->orderBy('employee_id')
            ->get();

        $users = User::query()
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        $selectedEmployeeId = $request->query('employee_id');

        if ($selectedEmployeeId === null && $employees->isNotEmpty()) {
            $selectedEmployeeId = $employees->first()->employee_id;
        }

        $selectedEmployee = $employees->firstWhere('employee_id', $selectedEmployeeId);

        $search = $request->query('search');

        $items = collect();

        if ($selectedEmployeeId !== null) {
            $items = Inventory::query()
                ->with(['employee', 'currentPropNo', 'currentUnitCost', 'currentEndUser', 'currentRemarks'])
                ->where('employee_id', $selectedEmployeeId)
                ->when($search, function ($query, $search) {
                    $query->whereHas('currentPropNo', function ($propQuery) use ($search) {
                        $propQuery->where('prop_no', 'like', '%'.$search.'%');
                    });
                })
                ->orderBy(
                    InventoryPropNoHistory::query()
                        ->select('prop_no')
                        ->whereColumn('inventory_id', 'inventory.id')
                        ->latest()
                        ->limit(1)
                )
                ->get();
        }

        $items = $this->attachLatestMovementToItems($items);

        if ($request->wantsJson()) {
            return response()->json([
                'selectedEmployee' => $selectedEmployee,
                'selectedEmployeeId' => $selectedEmployeeId,
                'items' => $items,
            ]);
        }

        return view('admin.coordinator', [
            'employees' => $employees,
            'employeeRecords' => $employees,
            'selectedEmployeeId' => $selectedEmployeeId,
            'selectedEmployee' => $selectedEmployee,
            'items' => $items,
            'search' => $search,
            'accountableCount' => $accountableCount,
            'unaccountableCount' => $unaccountableCount,
            'totalCount' => $totalCount,
            'dashboardAccountableItems' => $dashboardAccountableItems,
            'dashboardUnaccountableItems' => $dashboardUnaccountableItems,
            'dashboardTotalItems' => $dashboardTotalItems,
            'dashboardTrackerMovements' => $dashboardTrackerMovements,
            'users' => $users,
        ]);
    }

    public function checkItemDuplicate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'property_number' => ['required', 'string', 'max:8'],
            'rca_acctcode' => ['required', 'string', 'max:10'],
            'serialno' => ['nullable', 'string', 'max:30'],
        ]);

        $propertyNumber = trim($validated['property_number']);
        $accountCode = trim($validated['rca_acctcode']);
        $serialRaw = isset($validated['serialno']) ? trim((string) $validated['serialno']) : '';
        $serialNormalized = $serialRaw === '' ? null : $serialRaw;

        $duplicate = $this->inventoryItemDuplicateExists($propertyNumber, $accountCode, $serialNormalized);

        return response()->json([
            'duplicate' => $duplicate,
            'message' => $duplicate ? 'This item already exists.' : null,
        ]);
    }

    public function checkEditItemFieldDuplicates(Request $request, int $inventory): JsonResponse
    {
        $item = Inventory::query()->findOrFail($inventory);

        $validated = $request->validate([
            'property_number' => ['required', 'string', 'max:8'],
            'rca_acctcode' => ['required', 'string', 'max:10'],
            'serialno' => ['nullable', 'string', 'max:30'],
        ]);

        $errors = $this->collectEditItemDuplicateFieldErrors(
            $item,
            trim($validated['property_number']),
            trim($validated['rca_acctcode']),
            trim((string) ($validated['serialno'] ?? ''))
        );

        return response()->json([
            'valid' => $errors === [],
            'errors' => $errors,
        ]);
    }

    public function storeItem(Request $request): RedirectResponse|JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => ['required', 'string'],
            'property_number' => ['required', 'string', 'max:8', 'unique:inventory_propno_history,prop_no'],
            'rca_acctcode' => ['required', 'string', 'max:10'],
            'description' => ['required', 'string', 'max:500'],
            'serialno' => ['nullable', 'string', 'max:30'],
            'status' => ['required', 'string'],
            'unit_cost' => ['required', 'numeric'],
            'accountability' => ['required', 'string'],
            'pn_old' => ['nullable', 'string', 'max:8'],
            'pn_code_old' => ['nullable', 'string', 'max:6'],
            'mrr' => ['nullable', 'string', 'max:9'],
            'center' => ['nullable', 'string', 'max:20'],
            'end_user' => ['nullable', 'string', 'max:20'],
            'remarks' => ['nullable', 'string', 'max:500'],
        ]);

        $validator->after(function (\Illuminate\Validation\Validator $validator) use ($request): void {
            $propertyNumber = trim((string) $request->input('property_number', ''));
            $accountCode = trim((string) $request->input('rca_acctcode', ''));

            if ($propertyNumber === '' || $accountCode === '') {
                return;
            }

            if (strlen($propertyNumber) > 8 || strlen($accountCode) > 10) {
                return;
            }

            $serialRaw = trim((string) $request->input('serialno', ''));

            if (strlen($serialRaw) > 30) {
                return;
            }

            $serialNormalized = $serialRaw === '' ? null : $serialRaw;

            if (! $this->inventoryItemDuplicateExists($propertyNumber, $accountCode, $serialNormalized)) {
                return;
            }

            $message = 'This item already exists.';

            foreach (['property_number', 'rca_acctcode', 'serialno'] as $field) {
                $validator->errors()->add($field, $message);
            }
        });

        $validated = $validator->validate();

        $employeeId = $validated['employee_id'];
        $employee = Employee::query()->find($employeeId);

        $isAccountable = strcasecmp(trim($validated['accountability']), 'Accountable') === 0;

        $statusCode = match (strtolower(trim($validated['status']))) {
            'in use' => 'I',
            'defective', 'disposed' => 'D',
            default => 'A',
        };

        $item = Inventory::create([
            'employee_id' => $isAccountable ? $employeeId : null,
            'current_prop_no' => $validated['property_number'],
            'acct_code' => $validated['rca_acctcode'],
            'description' => $validated['description'],
            'serial_no' => $validated['serialno'] ?? null,
            'status' => $statusCode,
            'pn_old' => $validated['pn_old'] ?? null,
            'pn_code_old' => $validated['pn_code_old'] ?? null,
            'mrr_no' => $validated['mrr'] ?? null,
            'center' => $validated['center'] ?? null,
            'accountability' => $validated['accountability'] ?? null,
        ]);

        InventoryPropNoHistory::create([
            'inventory_id' => $item->id,
            'prop_no' => $validated['property_number'],
            'is_current' => true,
            'changed_at' => now(),
        ]);

        InventoryUnitCostHistory::create([
            'inventory_id' => $item->id,
            'unit_cost' => $validated['unit_cost'],
        ]);

        $initialEndUser = $validated['end_user'] ?? $employee?->employee_name ?? '';

        InventoryEndUserHistory::create([
            'inventory_id' => $item->id,
            'end_user' => $initialEndUser,
        ]);

        InventoryRemarksHistory::create([
            'inventory_id' => $item->id,
            'remark_text' => $validated['remarks'] ?? null,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Item added successfully.',
                'inventory_id' => $item->id,
                'prop_no' => $validated['property_number'],
            ]);
        }

        return redirect()
            ->route('admin.coordinator.index', ['employee_id' => $employeeId])
            ->with('status', 'Item added successfully.');
    }

    public function destroy(Request $request, int $inventory): RedirectResponse|JsonResponse
    {
        $item = Inventory::query()->findOrFail($inventory);
        $item->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Item deleted successfully.']);
        }

        $employeeId = $request->input('employee_id');

        return redirect()
            ->route('admin.coordinator.index', $employeeId ? ['employee_id' => $employeeId] : [])
            ->with('status', 'Item deleted successfully.');
    }

    public function updateItem(Request $request, int $inventory): RedirectResponse|JsonResponse
    {
        $item = Inventory::query()
            ->with(['currentPropNo', 'currentUnitCost', 'currentEndUser', 'currentRemarks'])
            ->findOrFail($inventory);

        $currentPropNo = (string) trim((string) ($item->prop_no ?? ''));

        $validator = Validator::make($request->all(), [
            'property_number' => ['required', 'string', 'max:8'],
            'rca_acctcode' => ['required', 'string', 'max:10'],
            'description' => ['required', 'string', 'max:500'],
            'serialno' => ['nullable', 'string', 'max:30'],
            'status' => ['required', 'string'],
            'unit_cost' => ['required', 'numeric'],
            'accountability' => ['required', 'string'],
            'pn_old' => ['nullable', 'string', 'max:8'],
            'pn_code_old' => ['nullable', 'string', 'max:6'],
            'mrr' => ['nullable', 'string', 'max:9'],
            'center' => ['nullable', 'string', 'max:20'],
            'end_user' => ['nullable', 'string', 'max:20'],
            'remarks' => ['nullable', 'string', 'max:500'],
        ]);

        $validator->after(function (\Illuminate\Validation\Validator $validator) use ($item, $request): void {
            $propertyNumber = trim((string) $request->input('property_number', ''));
            $accountCode = trim((string) $request->input('rca_acctcode', ''));
            $serialNo = trim((string) $request->input('serialno', ''));

            foreach ($this->collectEditItemDuplicateFieldErrors($item, $propertyNumber, $accountCode, $serialNo) as $field => $message) {
                $validator->errors()->add($field, $message);
            }
        });

        $validated = $validator->validate();

        $statusCode = match (strtolower(trim($validated['status']))) {
            'in use' => 'I',
            'defective', 'disposed' => 'D',
            default => 'A',
        };

        $isAccountable = strcasecmp(trim($validated['accountability']), 'Accountable') === 0;
        $employeeIdForUpdate = $isAccountable
            ? ($request->input('employee_id') ?: $item->employee_id)
            : null;

        $updatePayload = [
            'employee_id' => $employeeIdForUpdate,
            'acct_code' => $validated['rca_acctcode'],
            'description' => $validated['description'],
            'serial_no' => $validated['serialno'] ?? null,
            'status' => $statusCode,
            'pn_old' => $validated['pn_old'] ?? null,
            'pn_code_old' => $validated['pn_code_old'] ?? null,
            'mrr_no' => $validated['mrr'] ?? null,
            'center' => $validated['center'] ?? null,
            'accountability' => $validated['accountability'] ?? null,
        ];

        try {
            DB::transaction(function () use ($item, $validated, $updatePayload, $currentPropNo) {
                $item->update($updatePayload);

                $incomingPropNo = trim((string) ($validated['property_number'] ?? ''));
                if ($incomingPropNo !== $currentPropNo && $incomingPropNo !== '') {
                    $item->propNoHistory()->where('is_current', true)->update(['is_current' => false]);

                    InventoryPropNoHistory::create([
                        'inventory_id' => $item->id,
                        'prop_no' => $incomingPropNo,
                        'is_current' => true,
                        'changed_at' => now(),
                    ]);

                    $item->update(['current_prop_no' => $incomingPropNo]);
                }

                $currentUnitCost = $item->currentUnitCost?->unit_cost;
                if ((string) ($validated['unit_cost'] ?? '') !== (string) ($currentUnitCost ?? '')) {
                    InventoryUnitCostHistory::create([
                        'inventory_id' => $item->id,
                        'unit_cost' => $validated['unit_cost'],
                    ]);
                }

                $currentEndUser = (string) ($item->currentEndUser?->end_user ?? ($item->employee?->employee_name ?? ''));
                $incomingEndUser = (string) ($validated['end_user'] ?? $item->employee?->employee_name ?? '');
                if ($incomingEndUser !== $currentEndUser) {
                    InventoryEndUserHistory::create([
                        'inventory_id' => $item->id,
                        'end_user' => $incomingEndUser,
                    ]);
                }

                $currentRemarks = (string) ($item->currentRemarks?->remark_text ?? '');
                $incomingRemarks = (string) ($validated['remarks'] ?? '');
                if ($incomingRemarks !== $currentRemarks) {
                    InventoryRemarksHistory::create([
                        'inventory_id' => $item->id,
                        'remark_text' => $validated['remarks'] ?? null,
                    ]);
                }
            });
        } catch (\Throwable $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Update failed. Please try again.',
                    'error' => config('app.debug') ? $e->getMessage() : null,
                ], 500);
            }

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['update' => 'Update failed. Please try again.']);
        }

        $updatedItem = $item->fresh(['employee', 'currentPropNo', 'currentUnitCost', 'currentEndUser', 'currentRemarks']);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Equipment updated successfully.',
                'item' => $updatedItem,
            ]);
        }

        return redirect()
            ->route('admin.coordinator.index', ['employee_id' => $item->employee_id])
            ->with('status', 'Equipment updated successfully.');
    }

    public function updateEmployee(Request $request, string $employee): RedirectResponse|JsonResponse
    {
        $employeeRecord = Employee::query()->findOrFail($employee);

        $rules = [
            'employee_name' => ['required', 'string', 'max:255'],
            'center' => ['required', 'string', 'max:255'],
            'employee_type' => ['required', 'string', Rule::in(['Plantilla', 'Nonplantilla'])],
        ];

        if ($employeeRecord->user_id) {
            $rules['email'] = [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($employeeRecord->user_id),
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (! is_string($value)) {
                        $fail('Email domain must end with .com (e.g. you@example.com).');

                        return;
                    }

                    $normalized = strtolower(trim($value));
                    $atPos = strpos($normalized, '@');
                    if ($atPos === false || $atPos < 1 || $atPos === strlen($normalized) - 1) {
                        $fail('Use a valid email with a domain ending in .com (e.g. you@example.com).');

                        return;
                    }

                    $domain = substr($normalized, $atPos + 1);
                    if (! str_ends_with($domain, '.com')) {
                        $fail('Email domain must end with .com (e.g. you@example.com).');
                    }
                },
            ];
        } else {
            $rules['email'] = ['nullable', 'email', 'max:255'];
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($employeeRecord, $validated): void {
            $employeeRecord->update([
                'employee_name' => $validated['employee_name'],
                'center' => $validated['center'],
                'employee_type' => $validated['employee_type'],
            ]);

            if ($employeeRecord->user_id && array_key_exists('email', $validated) && $validated['email'] !== null) {
                User::query()->whereKey($employeeRecord->user_id)->update([
                    'email' => $validated['email'],
                    'name' => $validated['employee_name'],
                ]);
            }
        });

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Employee updated successfully.',
                'employee' => $employeeRecord->fresh('user'),
            ]);
        }

        return redirect()
            ->route('admin.coordinator.index')
            ->with('status', 'Employee updated successfully.');
    }

    public function listEmployees(): JsonResponse
    {
        $employees = Employee::query()
            ->with('user:id,email,name')
            ->orderBy('employee_id')
            ->get(['employee_id', 'employee_name', 'center', 'empl_status', 'employee_type', 'created_at', 'updated_at', 'user_id']);

        return response()->json([
            'employees' => $employees->map(function (Employee $employee) {
                return [
                    'employee_id' => $employee->employee_id,
                    'employee_name' => $employee->employee_name,
                    'center' => $employee->center,
                    'empl_status' => $employee->empl_status,
                    'employee_type' => $employee->employee_type,
                    'email' => $employee->user?->email ?? '',
                    'user_id' => $employee->user_id,
                    'created_at' => $employee->created_at,
                    'updated_at' => $employee->updated_at,
                ];
            }),
        ]);
    }

    public function storeEmployee(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (! is_string($value)) {
                        $fail('Email domain must end with .com (e.g. you@example.com).');

                        return;
                    }

                    $normalized = strtolower(trim($value));
                    $atPos = strpos($normalized, '@');
                    if ($atPos === false || $atPos < 1 || $atPos === strlen($normalized) - 1) {
                        $fail('Use a valid email with a domain ending in .com (e.g. you@example.com).');

                        return;
                    }

                    $domain = substr($normalized, $atPos + 1);
                    if (! str_ends_with($domain, '.com')) {
                        $fail('Email domain must end with .com (e.g. you@example.com).');
                    }
                },
            ],
            'role' => ['required', 'string', 'max:255'],
            'center' => ['required', 'string', 'max:255'],
            'employee_type' => ['required', 'string', Rule::in(['Plantilla', 'Nonplantilla'])],
        ], [
            'name.required' => 'Employee name is required.',
            'email.required' => 'Email is required.',
            'email.unique' => 'This email is already registered.',
            'role.required' => 'Role is required.',
            'center.required' => 'Center is required.',
            'employee_type.required' => 'Employee type is required.',
        ]);

        $emplStatus = 'active';

        $employeeRecord = DB::transaction(function () use ($validated, $emplStatus): Employee {
            $placeholderPassword = Hash::make(Str::random(64));

            $user = User::query()->create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $placeholderPassword,
                'role' => $validated['role'],
            ]);

            $latestEmployeeId = Employee::query()
                ->whereNotNull('employee_id')
                ->where('employee_id', 'like', 'EMP%')
                ->orderByRaw('CAST(SUBSTRING(employee_id, 4) AS UNSIGNED) DESC')
                ->value('employee_id');

            $nextNumber = 1;
            if (is_string($latestEmployeeId) && $latestEmployeeId !== '') {
                $numericPart = substr($latestEmployeeId, 3);
                $numericPart = (int) preg_replace('/\D/', '', $numericPart);
                $nextNumber = $numericPart + 1;
            }

            $nextEmployeeId = 'EMP'.str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);

            return Employee::query()->create([
                'employee_id' => $nextEmployeeId,
                'employee_name' => $user->name,
                'center' => $validated['center'],
                'empl_status' => $emplStatus,
                'employee_type' => $validated['employee_type'],
                'user_id' => $user->id,
            ]);
        });

        $user = User::query()->findOrFail($employeeRecord->user_id);
        $employeeRecord = $employeeRecord->fresh();

        $registrationUrl = URL::temporarySignedRoute(
            'complete-registration.show',
            now()->addDays(3),
            ['user' => $user->id],
        );

        $mailSent = false;
        try {
            Mail::to($user->email)->send(
                new EmployeeInvitationMail($user, $employeeRecord, $registrationUrl),
            );
            $mailSent = true;
        } catch (\Throwable $e) {
            Log::warning('Failed to send employee invitation email.', [
                'user_id' => $user->id,
                'exception' => $e->getMessage(),
            ]);
        }

        $statusMessage = $mailSent
            ? 'Employee added successfully. Invitation email has been sent.'
            : 'Employee added successfully. The invitation email could not be sent. Please contact support or resend the invitation.';

        if ($request->wantsJson()) {
            return response()->json([
                'message' => $statusMessage,
                'employee' => $employeeRecord,
                'invitation_mail_sent' => $mailSent,
            ]);
        }

        return redirect()
            ->route('admin.coordinator.index')
            ->with('status', $statusMessage);
    }

    public function destroyEmployee(Request $request, string $employee): RedirectResponse|JsonResponse
    {
        $employeeRecord = Employee::query()->findOrFail($employee);

        // Prevent FK constraint failures when the employee is referenced by gatepass_requests.
        if (GatepassRequest::query()->where('requester_employee_id', $employeeRecord->employee_id)->exists()) {
            $message = 'Cannot delete employee because they are referenced by existing gate pass requests.';

            if ($request->wantsJson()) {
                return response()->json(['message' => $message], 409);
            }

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['delete' => $message]);
        }

        try {
            $employeeRecord->delete();
        } catch (QueryException $e) {
            $message = 'Unable to delete employee. Please remove related records first.';

            if ($request->wantsJson()) {
                return response()->json(['message' => $message], 409);
            }

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['delete' => $message]);
        }

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Employee deleted successfully.']);
        }

        return redirect()
            ->route('admin.coordinator.index')
            ->with('status', 'Employee deleted successfully.');
    }

    private function inventoryItemDuplicateExists(string $propertyNumber, string $accountCode, ?string $serialNo): bool
    {
        return Inventory::query()
            ->where('current_prop_no', $propertyNumber)
            ->where('acct_code', $accountCode)
            ->where(function ($query) use ($serialNo) {
                if ($serialNo === null) {
                    $query->whereNull('serial_no')->orWhere('serial_no', '');
                } else {
                    $query->where('serial_no', $serialNo);
                }
            })
            ->exists();
    }

    /**
     * @param  Collection<int, Inventory>  $items
     * @return Collection<int, Inventory>
     */
    private function attachLatestMovementToItems(Collection $items): Collection
    {
        if ($items->isEmpty()) {
            return $items;
        }

        $inventoryIds = $items->pluck('id')->filter()->values()->all();
        if ($inventoryIds === []) {
            return $items;
        }

        $latestRows = DB::table('gatepass_items as gpi')
            ->join('gatepass_logs as gl', 'gl.gatepass_no', '=', 'gpi.gatepass_no')
            ->leftJoin('employees as requester', 'requester.employee_id', '=', 'gl.requester_employee_id')
            ->whereIn('gpi.inventory_id', $inventoryIds)
            ->whereIn('gl.log_type', ['INCOMING', 'OUTGOING'])
            ->orderByDesc('gl.log_datetime')
            ->orderByDesc('gl.log_id')
            ->get([
                'gpi.inventory_id',
                'gl.log_type',
                'gl.log_datetime',
                'requester.employee_name as requester_name',
            ])
            ->groupBy('inventory_id')
            ->map(static function ($rows) {
                $row = $rows->first();
                if ($row === null) {
                    return null;
                }

                $formattedDateTime = null;
                if (! empty($row->log_datetime)) {
                    try {
                        $formattedDateTime = Carbon::parse($row->log_datetime)->format('Y-m-d H:i:s');
                    } catch (\Throwable) {
                        $formattedDateTime = (string) $row->log_datetime;
                    }
                }

                return [
                    'type' => (string) ($row->log_type ?? ''),
                    'datetime' => $formattedDateTime,
                    'requester_name' => (string) ($row->requester_name ?? ''),
                ];
            });

        return $items->map(function (Inventory $item) use ($latestRows): Inventory {
            $movement = $latestRows->get($item->id);
            $item->setAttribute('latest_movement', is_array($movement) ? $movement : null);

            return $item;
        });
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    private function getDashboardTrackerMovements(): Collection
    {
        $rows = DB::table('gatepass_logs as gl')
            ->join('gatepass_items as gpi', 'gpi.gatepass_no', '=', 'gl.gatepass_no')
            ->join('inventory as i', 'i.id', '=', 'gpi.inventory_id')
            ->whereIn('gl.log_type', ['INCOMING', 'OUTGOING'])
            ->orderByDesc('gl.log_datetime')
            ->orderByDesc('gl.log_id')
            ->get([
                'i.id as inventory_id',
                'i.current_prop_no as prop_no',
                'i.description',
                'gl.log_type',
                'gl.log_datetime',
            ]);

        return $rows
            ->groupBy('inventory_id')
            ->map(static function (Collection $itemRows): array {
                $firstRow = $itemRows->first();
                $incomingHistory = [];
                $outgoingHistory = [];
                $latestMovementDatetime = null;

                foreach ($itemRows as $row) {
                    $formattedDateTime = null;
                    if (! empty($row->log_datetime)) {
                        try {
                            $formattedDateTime = Carbon::parse($row->log_datetime)->format('Y-m-d H:i:s');
                        } catch (\Throwable) {
                            $formattedDateTime = (string) $row->log_datetime;
                        }
                    }

                    if ($latestMovementDatetime === null && $formattedDateTime !== null) {
                        $latestMovementDatetime = $formattedDateTime;
                    }

                    if ((string) $row->log_type === 'INCOMING') {
                        $incomingHistory[] = $formattedDateTime;
                    }

                    if ((string) $row->log_type === 'OUTGOING') {
                        $outgoingHistory[] = $formattedDateTime;
                    }
                }

                return [
                    'inventory_id' => (int) ($firstRow->inventory_id ?? 0),
                    'prop_no' => (string) ($firstRow->prop_no ?? ''),
                    'description' => (string) ($firstRow->description ?? ''),
                    'latest_movement_datetime' => $latestMovementDatetime,
                    'incoming_history' => array_values(array_filter($incomingHistory)),
                    'outgoing_history' => array_values(array_filter($outgoingHistory)),
                ];
            })
            ->sortByDesc('latest_movement_datetime')
            ->values();
    }

    /**
     * @return array<string, string>
     */
    private function collectEditItemDuplicateFieldErrors(Inventory $item, string $propertyNumber, string $accountCode, string $serialNo): array
    {
        $errors = [];

        $currentProp = trim((string) ($item->prop_no ?? $item->current_prop_no ?? ''));
        $currentAcct = trim((string) ($item->acct_code ?? ''));
        $currentSerial = trim((string) ($item->serial_no ?? ''));

        if ($propertyNumber !== $currentProp && $propertyNumber !== '') {
            if (InventoryPropNoHistory::query()
                ->where('prop_no', $propertyNumber)
                ->where('inventory_id', '!=', $item->id)
                ->exists()) {
                $errors['property_number'] = 'Property number already exists';
            }
        }

        if ($serialNo !== $currentSerial && $serialNo !== '') {
            if (Inventory::query()->whereKeyNot($item->id)->where('serial_no', $serialNo)->exists()) {
                $errors['serialno'] = 'Serial number already exists';
            }
        }

        if ($accountCode !== $currentAcct && $accountCode !== '') {
            if (Inventory::query()->whereKeyNot($item->id)->where('acct_code', $accountCode)->exists()) {
                $errors['rca_acctcode'] = 'Account code already exists';
            }
        }

        return $errors;
    }
}
