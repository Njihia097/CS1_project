<?php

use App\Http\Controllers\Admin\Admin_EditorController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
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


Route::get('/roles', [LoginController::class, 'authenticated']);


Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/home', [AdminController::class,'adminHome'])->name('adminHome');
    Route::get('/register-editor', [Admin_EditorController::class, 'view'])->name('register-editor');
    Route::post('/register-editor', [Admin_EditorController::class, 'store'])->name('register-editor');
});


Route::middleware(['auth', 'role:editor'])->name('editor.')->prefix('editor')->group(function () {
    Route::get('/home', [EditorController::class, 'editorHome'])->name('editorHome');
});

Route::middleware(['auth', 'role:student'])->name('student.')->prefix('student')->group(function () {
    Route::get('/home', [StudentController::class, 'studentHome'])->name('studentHome');
});

