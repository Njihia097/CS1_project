<?php

use App\Http\Controllers\Admin\Admin_EditorController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Editor\EditorController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Auth\LockScreenController;
use App\Http\Controllers\Student\ContentController;
use App\Http\Controllers\Student\HomeController;

Route::get('/', [HomeController::class,'index']
);

Route::middleware(['auth',config('jetstream.auth_session')])->get('/', function () {
    return view('home.userpage');
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

// Removed -> ,'check.locked'
Route::middleware(['auth',config('jetstream.auth_session'),'verified','role:admin'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::get('/home', [AdminController::class,'adminHome'])->name('adminHome');
        Route::get('/register-editor', [Admin_EditorController::class, 'view'])->name('register-editor');
        Route::post('/register-editor', [Admin_EditorController::class, 'store'])->name('register-editor');
});


Route::middleware(['auth',config('jetstream.auth_session'),'verified','role:editor'])
    ->name('editor.')
    ->prefix('editor')
    ->group(function () {
        Route::get('/home', [EditorController::class, 'editorHome'])->name('editorHome');
});

Route::middleware(['auth',config('jetstream.auth_session'),'verified','role:student'])
    ->name('student.')
    ->prefix('student')
    ->group(function () {
        Route::get('/home', [StudentController::class, 'studentHome'])->name('studentHome');
        Route::get('/Content-setup', [ContentController::class, 'view'])->name('Content-setup');
        Route::post('/Content-setup', [ContentController::class, 'store'])->name('Content-setup');
        Route::get('/content/{ContentID}/edit', [ContentController::class, 'edit'])->name('editContent');
        Route::put('/content/{ContentID}', [ContentController::class, 'update'])->name('updateContent');
});

route::get('/view_artsale',[HomeController::class,'view_artsale']);

route::get('/view_userpage',[HomeController::class,'view_userpage']);

route::get('/view_blogpage',[HomeController::class,'view_blogpage']);

route::get('/view_contact',[HomeController::class,'view_contact']);

