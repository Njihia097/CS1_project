<?php

use App\Http\Controllers\Admin\Admin_EditorController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Editor\EditorController;
use App\Http\Controllers\Student\StudentController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;


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

// Email Verification Notice Route
Route::get('/email/verify', function() {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Email Verification Route
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->route('editor.password.reset.notice');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Resend Verification Email Route
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerification(); //Changed from sendEmailVerificationNotification()

    return back()->with('message', 'verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send'); // Limit number of requests to 6 per minute


Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');




Route::get('/roles', [LoginController::class, 'authenticated']);


Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/home', [AdminController::class,'adminHome'])->name('adminHome');
    Route::view('/register-editor', 'register-editor');
    Route::post('/register-editor', [Admin_EditorController::class, 'store'])->name('register-editor');
});

Route::middleware(['auth', 'role:editor'])->name('editor.')->prefix('editor')->group(function () {
    Route::get('/home', [EditorController::class, 'editorHome'])->name('editorHome');
    Route::view('/password/reset/notice', 'auth.passwords.reset-notice')->name('password.reset.notice');
});

Route::middleware(['auth', 'role:student'])->name('student.')->prefix('student')->group(function () {
    Route::get('/home', [StudentController::class, 'studentHome'])->name('studentHome');
});

