<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CoordinatorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::get('/dashboard', function () {
    return view('employee.dashboard');
})->middleware('auth');

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');

Route::get('/register', function () {
    return 'Register page here';
});

Route::get('/employee/dashboard', function () {
    return view('employee.dashboard');
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
