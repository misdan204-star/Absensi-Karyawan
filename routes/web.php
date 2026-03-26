<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

// Halaman utama: Redirect ke admin jika admin, ke absensi jika user, welcome jika tidak login
Route::get('/', function () {
    if (!auth()->check()) {
        return view('welcome');
    }
    return auth()->user()->isAdmin() ? redirect('/admin') : redirect('/absensi');
});

Route::post('/api/login', [ApiController::class, 'login']);

// Halaman Absensi (Protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/absensi', function () {
        return view('absensi');
    })->name('absensi');

    Route::get('/api/history', [AttendanceController::class, 'index'])->middleware('throttle:60,1');
    Route::post('/api/absen', [AttendanceController::class, 'store'])->middleware('throttle:10,1');
    Route::get('/api/user', [\App\Http\Controllers\ApiController::class, 'user']);
    
    // Default Dashboard dari Breeze (Opsional)
    Route::get('/dashboard', function () {
        return auth()->user()->isAdmin() ? redirect()->route('admin.dashboard') : redirect()->route('absensi');
    })->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Admin Routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/export', [AdminController::class, 'export'])->name('admin.export');
        Route::get('/admin/leave', [LeaveController::class, 'adminIndex'])->name('admin.leave.index');
        Route::post('/admin/leave/{leaveRequest}/status', [LeaveController::class, 'updateStatus'])->name('admin.leave.status');
        Route::resource('/admin/users', \App\Http\Controllers\AdminUserController::class)->names([
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ]);
    });

    // Leave Routes (Common for Auth Users)
    Route::get('/leave', [LeaveController::class, 'index'])->name('leave.index');
    Route::get('/leave/create', [LeaveController::class, 'create'])->name('leave.create');
    Route::post('/leave', [LeaveController::class, 'store'])->name('leave.store');
});

require __DIR__.'/auth.php';
