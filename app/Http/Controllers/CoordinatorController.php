<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\MasterProperty;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CoordinatorController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $accountableCount = MasterProperty::query()
            ->whereNotNull('accountable_employee_id')
            ->count();

        $unaccountableCount = MasterProperty::query()
            ->whereNull('accountable_employee_id')
            ->count();

        $totalCount = MasterProperty::query()->count();

        $dashboardAccountableItems = MasterProperty::query()
            ->with('accountableEmployee')
            ->whereNotNull('accountable_employee_id')
            ->orderBy('propno')
            ->get();

        $dashboardUnaccountableItems = MasterProperty::query()
            ->with('accountableEmployee')
            ->whereNull('accountable_employee_id')
            ->orderBy('propno')
            ->get();

        $dashboardTotalItems = MasterProperty::query()
            ->with('accountableEmployee')
            ->orderBy('propno')
            ->get();

        $employees = Employee::with('user')
            ->orderBy('employee_id')
            ->get();

        $selectedEmployeeId = $request->query('employee_id');

        if ($selectedEmployeeId === null && $employees->isNotEmpty()) {
            $selectedEmployeeId = $employees->first()->employee_id;
        }

        $selectedEmployee = $employees->firstWhere('employee_id', $selectedEmployeeId);

        $search = $request->query('search');

        $items = collect();

        if ($selectedEmployeeId !== null) {
            $items = MasterProperty::query()
                ->with('accountableEmployee')
                ->where('accountable_employee_id', $selectedEmployeeId)
                ->when($search, function ($query, $search) {
                    $query->where(function ($innerQuery) use ($search) {
                        $innerQuery
                            ->where('propno', 'like', '%'.$search.'%')
                            ->orWhere('description', 'like', '%'.$search.'%')
                            ->orWhere('serialno', 'like', '%'.$search.'%');
                    });
                })
                ->orderBy('propno')
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
        ]);
    }

    public function storeItem(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employee_id' => ['required', 'string'],
            'property_number' => ['required', 'string', 'unique:master_property,propno'],
            'rca_acctcode' => ['required', 'string'],
            'description' => ['required', 'string'],
            'serialno' => ['nullable', 'string'],
            'status' => ['required', 'string'],
            'unit_cost' => ['required', 'numeric'],
            'accountability' => ['required', 'string'],
        ]);

        $employeeId = $validated['employee_id'];

        $statusCode = null;

        if (! empty($validated['status'])) {
            $statusCode = 'A';
        }

        MasterProperty::create([
            'propno' => $validated['property_number'],
            'rca_acctcode' => $validated['rca_acctcode'],
            'description' => $validated['description'] ?? null,
            'serialno' => $validated['serialno'] ?? null,
            'status' => $statusCode,
            'unitcost' => $validated['unit_cost'] ?? null,
            'accountable_employee_id' => $employeeId,
        ]);

        return redirect()
            ->route('admin.coordinator.index', ['employee_id' => $employeeId])
            ->with('status', 'Item added successfully.');
    }

    public function destroy(Request $request, string $propno): RedirectResponse
    {
        $item = MasterProperty::query()->findOrFail($propno);
        $item->delete();

        $employeeId = $request->input('employee_id');

        return redirect()
            ->route('admin.coordinator.index', $employeeId ? ['employee_id' => $employeeId] : [])
            ->with('status', 'Item deleted successfully.');
    }
}
