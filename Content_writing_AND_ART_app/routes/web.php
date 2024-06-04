<?php

use App\Http\Controllers\Admin\Admin_EditorController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Editor\EditorController;
use App\Http\Controllers\Student\StudentController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


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

Route::get('/email/verify', function() {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->route('editor.editorHome');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send'); // Limit number of requests to 6 per minute

Route::get('/roles', [LoginController::class, 'authenticated']);


Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/home', [AdminController::class,'adminHome'])->name('adminHome');
    Route::view('/register-editor', 'register-editor');
    Route::post('/register-editor', [Admin_EditorController::class, 'store'])->name('register-editor');
});

Route::middleware(['auth', 'role:editor'])->name('editor.')->prefix('editor')->group(function () {
    Route::get('/home', [EditorController::class, 'editorHome'])->name('editorHome');
});

Route::middleware(['auth', 'role:student'])->name('student.')->prefix('student')->group(function () {
    Route::get('/home', [StudentController::class, 'studentHome'])->name('studentHome');
});

