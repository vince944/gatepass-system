<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CoordinatorController;
use App\Models\Employee;
use App\Models\Inventory;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::get('/dashboard', function () {
    $user = auth()->user();

    $employee = $user
        ? Employee::query()->where('user_id', $user->id)->first()
        : null;

    $equipment = $employee
        ? Inventory::query()
            ->where('employee_id', $employee->employee_id)
            ->orderBy('current_prop_no')
            ->get()
        : collect();

    return view('employee.dashboard', [
        'employee' => $employee,
        'employeeFullName' => $employee?->employee_name ?? $user?->name,
        'equipment' => $equipment,
    ]);
})->middleware('auth');

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');

Route::get('/register', function () {
    return 'Register page here';
});

Route::get('/employee/dashboard', function () {
    $user = auth()->user();

    $employee = $user
        ? Employee::query()->where('user_id', $user->id)->first()
        : null;

    $equipment = $employee
        ? Inventory::query()
            ->where('employee_id', $employee->employee_id)
            ->orderBy('current_prop_no')
            ->get()
        : collect();

    return view('employee.dashboard', [
        'employee' => $employee,
        'employeeFullName' => $employee?->employee_name ?? $user?->name,
        'equipment' => $equipment,
    ]);
})->middleware('auth');

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth');

Route::get('/coordinator/dashboard', [CoordinatorController::class, 'index'])
    ->middleware('auth')
    ->name('admin.coordinator.index');

Route::get('/coordinator/items', function () {
    return redirect()->route('admin.coordinator.index');
})
    ->middleware('auth')
    ->name('admin.coordinator.items.index');

Route::post('/coordinator/items', [CoordinatorController::class, 'storeItem'])
    ->middleware('auth')
    ->name('admin.coordinator.items.store');

Route::put('/coordinator/items/{inventory}', [CoordinatorController::class, 'updateItem'])
    ->middleware('auth')
    ->name('admin.coordinator.items.update');

Route::delete('/coordinator/items/{inventory}', [CoordinatorController::class, 'destroy'])
    ->middleware('auth')
    ->name('admin.coordinator.items.destroy');
