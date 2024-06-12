<?php

use App\Http\Controllers\Admin\Admin_EditorController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Editor\EditorController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Auth\LockScreenController;
use App\Http\Controllers\Student\StoryController;


Route::middleware(['check.locked'])->get('/', function () {
    return view('welcome');
})->name('welcome');


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

Route::get('auth/google', [GoogleController::class, 'redirect'])->name('google-auth');
Route::get('auth/google/call-back', [GoogleController::class, 'callbackGoogle']);

Route::middleware('auth')->get('/lock-screen', [LockScreenController::class, 'showLockScreen'])->name('lock-screen');
Route::middleware('auth')->post('/unclock', [LockScreenController::class, 'unlock'])->name('unlock');


Route::middleware(['auth',config('jetstream.auth_session'),'verified','check.locked','role:admin'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::get('/home', [AdminController::class,'adminHome'])->name('adminHome');
        Route::get('/register-editor', [Admin_EditorController::class, 'view'])->name('register-editor');
        Route::post('/register-editor', [Admin_EditorController::class, 'store'])->name('register-editor');
});


Route::middleware(['auth',config('jetstream.auth_session'),'verified','check.locked','role:editor'])
    ->name('editor.')
    ->prefix('editor')
    ->group(function () {
        Route::get('/home', [EditorController::class, 'editorHome'])->name('editorHome');
});

Route::middleware(['auth',config('jetstream.auth_session'),'verified','check.locked','role:student'])
    ->name('student.')
    ->prefix('student')
    ->group(function () {
        Route::get('/home', [StudentController::class, 'studentHome'])->name('studentHome');
        Route::get('/createStory', [StoryController::class, 'view'])->name('createStory');
});

