<?php

namespace App\Http\Controllers;

use App\Mail\EmployeeInvitationMail;
use App\Models\Employee;
use App\Models\Inventory;
use App\Models\InventoryEndUserHistory;
use App\Models\InventoryPropNoHistory;
use App\Models\InventoryRemarksHistory;
use App\Models\InventoryUnitCostHistory;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
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
            'users' => $users,
        ]);
    }

    public function storeItem(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
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

        $currentPropNo = (string) ($item->prop_no ?? '');
        $incomingPropNo = (string) trim($request->input('property_number', ''));

        $propNoRules = ['required', 'string', 'max:8'];
        if ($incomingPropNo !== '' && $incomingPropNo !== $currentPropNo) {
            $propNoRules[] = Rule::unique('inventory_propno_history', 'prop_no');
        }

        $validated = $request->validate([
            'property_number' => $propNoRules,
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
        ], [
            'property_number.unique' => 'The property number already exists. Please use a different number.',
        ]);

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

                $incomingPropNo = (string) trim($validated['property_number'] ?? '');
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

        $validated = $request->validate([
            'employee_name' => ['required', 'string', 'max:255'],
            'center' => ['required', 'string', 'max:255'],
            'empl_status' => ['required', 'string', 'max:255'],
        ]);

        $employeeRecord->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Employee updated successfully.',
                'employee' => $employeeRecord->fresh(),
            ]);
        }

        return redirect()
            ->route('admin.coordinator.index')
            ->with('status', 'Employee updated successfully.');
    }

    public function listEmployees(): JsonResponse
    {
        $employees = Employee::query()
            ->orderBy('employee_id')
            ->get(['employee_id', 'employee_name', 'center', 'empl_status', 'created_at', 'updated_at']);

        return response()->json([
            'employees' => $employees,
        ]);
    }

    public function storeEmployee(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'string', 'max:255'],
            'center' => ['required', 'string', 'max:255'],
            'empl_status' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => 'Employee name is required.',
            'email.required' => 'Email is required.',
            'email.unique' => 'This email is already registered.',
            'role.required' => 'Role is required.',
            'center.required' => 'Center is required.',
        ]);

        $emplStatusRaw = $validated['empl_status'] ?? '';
        $emplStatus = trim((string) $emplStatusRaw);
        if ($emplStatus === '') {
            $emplStatus = 'active';
        }

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
        $employeeRecord->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Employee deleted successfully.']);
        }

        return redirect()
            ->route('admin.coordinator.index')
            ->with('status', 'Employee deleted successfully.');
    }
}
