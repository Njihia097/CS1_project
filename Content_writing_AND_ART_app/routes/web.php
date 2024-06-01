<?php

use Illuminate\Support\Facades\Route;
use app\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Editor\EditorController;
use App\Http\Controllers\Student\StudentController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});

Route::middleware(['auth', 'role:editor'])->name('editor.')->prefix('editor')->group(function () {
    Route::get('/editor/dashboard', [EditorController::class, 'dashboard'])->name('dashboard');
});

Route::middleware(['auth', 'role:student'])->name('student.')->prefix('student')->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
});

