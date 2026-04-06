<?php

use App\Http\Controllers\AdminGatepassRequestController;
use App\Http\Controllers\Auth\CompleteRegistrationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\EmployeeGatepassRequestController;
use App\Http\Controllers\EmployeeProfileController;
use App\Http\Controllers\GuardGatepassLogController;
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

Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'show'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'update'])
    ->middleware('guest')
    ->name('password.update');

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

Route::put('/employee/profile', [EmployeeProfileController::class, 'update'])
    ->middleware('auth')
    ->name('employee.profile.update');

Route::post('/employee/gatepass-requests', [EmployeeGatepassRequestController::class, 'store'])
    ->middleware('auth')
    ->name('employee.gatepass-requests.store');

Route::get('/employee/gatepass-requests/history', [EmployeeGatepassRequestController::class, 'history'])
    ->middleware('auth')
    ->name('employee.gatepass-requests.history');

Route::get('/employee/gatepass-requests/dashboard', [EmployeeGatepassRequestController::class, 'dashboard'])
    ->middleware('auth')
    ->name('employee.gatepass-requests.dashboard');

Route::get('/employee/gatepass-requests/{gatepass_no}', [EmployeeGatepassRequestController::class, 'show'])
    ->where('gatepass_no', '.*')
    ->middleware('auth')
    ->name('employee.gatepass-requests.show');

Route::get('/employee/gatepass-requests/{gatepass_no}/qr-code', [EmployeeGatepassRequestController::class, 'qrCode'])
    ->where('gatepass_no', '.*')
    ->middleware('auth')
    ->name('employee.gatepass-requests.qr-code');

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');

Route::get('/admin/dashboard', [AdminGatepassRequestController::class, 'index'])
    ->middleware('auth')
    ->name('admin.dashboard');

Route::get('/admin/gatepass-requests/{gatepassNo}', [AdminGatepassRequestController::class, 'show'])
    ->where('gatepassNo', '.*')
    ->middleware('auth')
    ->name('admin.gatepass-requests.show');

Route::post('/admin/gatepass-requests/{gatepassNo}/approve', [AdminGatepassRequestController::class, 'approve'])
    ->where('gatepassNo', '.*')
    ->middleware('auth')
    ->name('admin.gatepass-requests.approve');

Route::post('/admin/gatepass-requests/{gatepassNo}/qr-code', [AdminGatepassRequestController::class, 'storeQrCode'])
    ->where('gatepassNo', '.*')
    ->middleware('auth')
    ->name('admin.gatepass-requests.store-qr-code');

Route::post('/admin/gatepass-requests/{gatepassNo}/reject', [AdminGatepassRequestController::class, 'reject'])
    ->where('gatepassNo', '.*')
    ->middleware('auth')
    ->name('admin.gatepass-requests.reject');

Route::get('/coordinator/dashboard', [CoordinatorController::class, 'index'])
    ->middleware('auth')
    ->name('admin.coordinator.index');

Route::get('/coordinator/items', function () {
    return redirect()->route('admin.coordinator.index');
})
    ->middleware('auth')
    ->name('admin.coordinator.items.index');

Route::get('/coordinator/items/check-duplicate', [CoordinatorController::class, 'checkItemDuplicate'])
    ->middleware('auth')
    ->name('admin.coordinator.items.duplicate-check');

Route::get('/coordinator/items/{inventory}/check-field-duplicates', [CoordinatorController::class, 'checkEditItemFieldDuplicates'])
    ->middleware('auth')
    ->name('admin.coordinator.items.check-field-duplicates');

Route::post('/coordinator/items', [CoordinatorController::class, 'storeItem'])
    ->middleware('auth')
    ->name('admin.coordinator.items.store');

Route::put('/coordinator/items/{inventory}', [CoordinatorController::class, 'updateItem'])
    ->middleware('auth')
    ->name('admin.coordinator.items.update');

Route::delete('/coordinator/items/{inventory}', [CoordinatorController::class, 'destroy'])
    ->middleware('auth')
    ->name('admin.coordinator.items.destroy');

Route::put('/coordinator/employees/{employee}', [CoordinatorController::class, 'updateEmployee'])
    ->middleware('auth')
    ->name('admin.coordinator.employees.update');

Route::get('/coordinator/employees', [CoordinatorController::class, 'listEmployees'])
    ->middleware('auth')
    ->name('admin.coordinator.employees.list');

Route::post('/coordinator/employees', [CoordinatorController::class, 'storeEmployee'])
    ->middleware('auth')
    ->name('admin.coordinator.employees.store');

Route::delete('/coordinator/employees/{employee}', [CoordinatorController::class, 'destroyEmployee'])
    ->middleware('auth')
    ->name('admin.coordinator.employees.destroy');

Route::get('/gdtest', function () {
    return view('admin.gdtest');
});

Route::get('/guard', function () {
    return view('guard.guard');
})
    ->middleware('auth')
    ->name('guard');

Route::get('/guard/gatepass-logs/next', [GuardGatepassLogController::class, 'next'])
    ->middleware('auth')
    ->name('guard.gatepass-logs.next');

Route::post('/guard/gatepass-logs', [GuardGatepassLogController::class, 'store'])
    ->middleware('auth')
    ->name('guard.gatepass-logs.store');

Route::get('/guard/gatepass-items', [GuardGatepassLogController::class, 'items'])
    ->middleware('auth')
    ->name('guard.gatepass-items');

Route::post('/guard/gatepass-partial-return', [GuardGatepassLogController::class, 'partialReturn'])
    ->middleware('auth')
    ->name('guard.gatepass-partial-return');

Route::post('/guard/gatepass-reject', [GuardGatepassLogController::class, 'reject'])
    ->middleware('auth')
    ->name('guard.gatepass-reject');

Route::get('/complete-registration/{user}', [CompleteRegistrationController::class, 'show'])
    ->name('complete-registration.show')
    ->middleware('signed');

Route::post('/complete-registration/{user}', [CompleteRegistrationController::class, 'store'])
    ->name('complete-registration.store')
    ->middleware('signed');
