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


Route::middleware(['auth',config('jetstream.auth_session')])->get('/', function () {
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
        Route::get('/home/about', [StudentController::class, 'showAbout'])->name('home.about');
        Route::get('/home/artwork', [StudentController::class, 'showArtwork'])->name('home.artwork');
        Route::get('/home/readingList', [StudentController::class, 'showReadingList'])->name('home.readingList');
        Route::get('/home/content', [StudentController::class, 'showContent'])->name('home.content');
        Route::get('/contentDetails/{content}', [ContentController::class, 'showContentDetails'])->name('contentDetails');
        Route::post('/contentDetails/{content}', [ContentController::class, 'saveContentDetails'])->name('saveContentDetails');
        Route::get('/api/contentDetails/{contentId}', [ContentController::class, 'getContentDetails']);


});

