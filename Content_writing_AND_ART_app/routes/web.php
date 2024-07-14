<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Admin_EditorController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Editor\EditorController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Auth\LockScreenController;
use App\Http\Controllers\Student\ContentController;
use App\Http\Controllers\Student\HomeController;
use App\Http\Controllers\Student\ArtistController;
use App\Http\Controllers\Student\CartController;
use App\Http\Controllers\Student\PayController;


Route::get('/', [HomeController::class, 'index'])->name('home.userpage');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/roles', [LoginController::class, 'authenticated']);

Route::get('auth/google', [GoogleController::class, 'redirect'])->name('google-auth');
Route::get('auth/google/call-back', [GoogleController::class, 'callbackGoogle']);

Route::middleware('auth')->group(function () {
    Route::get('/lock-screen', [LockScreenController::class, 'showLockScreen'])->name('lock-screen');
    Route::post('/unclock', [LockScreenController::class, 'unlock'])->name('unlock');
});

// Admin routes
Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/home', [AdminController::class, 'adminHome'])->name('adminHome');
        Route::get('/register-editor', [Admin_EditorController::class, 'view'])->name('register-editor');
        Route::post('/register-editor', [Admin_EditorController::class, 'store'])->name('registerEditor');
});



// Editor routes
Route::middleware(['auth', 'verified', 'role:editor'])
    ->prefix('editor')
    ->name('editor.')
    ->group(function () {
        Route::get('/home', [EditorController::class, 'editorHome'])->name('editorHome');
    });

// Student routes
Route::middleware(['auth', 'verified', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/home', [StudentController::class, 'studentHome'])->name('studentHome');
        Route::get('/Content-setup', [ContentController::class, 'view'])->name('Content-setup');
        Route::post('/Content-setup', [ContentController::class, 'store'])->name('ContentSetup');
        Route::get('/content/{ContentID}/edit', [ContentController::class, 'edit'])->name('editContent');
        Route::put('/content/{ContentID}', [ContentController::class, 'update'])->name('updateContent');

        // Merged routes from both conflicting changes
        Route::get('/home/about', [StudentController::class, 'showAbout'])->name('home.about');
        Route::get('/home/artwork', [StudentController::class, 'showArtwork'])->name('home.artwork');
        Route::get('/home/readingList', [StudentController::class, 'showReadingList'])->name('home.readingList');
        Route::get('/home/content', [StudentController::class, 'showContent'])->name('home.content');
        Route::get('/contentDetails/{content}', [ContentController::class, 'showContentDetails'])->name('contentDetails');
        Route::post('/contentDetails/{content}', [ContentController::class, 'saveContentDetails'])->name('saveContentDetails');
        Route::get('/api/contentDetails/{contentId}', [ContentController::class, 'getContentDetails']);
        Route::post('/content/{ContentID}/new-chapter', [ContentController::class, 'createNewChapter'])->name('createNewChapter');
        Route::delete('/content/{id}', [ContentController::class, 'destroy'])->name('content.destroy');
        Route::delete('/content/{contentId}/chapter/{chapterId}', [ContentController::class, 'destroyChapter'])->name('content.destroyChapter');         
    });

    Route::get('public/content-view/{id}', [ContentController::class, 'viewContent'])->name('publicView.contentDescription');
    Route::get('public/start-reading/{id}', [ContentController::class, 'startReading'])->name('publicView.startReading');
    Route::get('public/chapter/{id}', [ContentController::class, 'viewChapter'])->name('publicView.chapter');


// Additional routes
Route::get('/redirect', [HomeController::class, 'redirect']);

Route::get('/view_artsale', [HomeController::class, 'view_artsale'])->name('artsale');
Route::get('/view_userpage', [HomeController::class, 'view_userpage'])->name('userpage');
Route::get('/view_blogpage', [HomeController::class, 'view_blogpage'])->name('blogpage');
Route::get('/view_contact', [HomeController::class, 'view_contact'])->name('contact');
Route::get('/view_artform', [HomeController::class, 'view_artform'])->name('artform');

Route::get('/artists/create', [ArtistController::class, 'create'])->name('artists.create');
Route::post('/artists', [ArtistController::class, 'store'])->name('artists.store');
Route::get('/artists', [ArtistController::class, 'index'])->name('artists.index');


Route::get('/add_cart/{id}', [CartController::class, 'add_cart'])->name('add_cart');
Route::get('/show_cart', [CartController::class, 'show_cart'])->name('show_cart');
Route::get('/remove_cart/{id}', [CartController::class, 'remove_cart'])->name('remove_cart');

Route::get('/show_order',[CartController::class, 'show_order']);
Route::get('/cash_order',[CartController::class, 'cash_order']);
Route::get('/remove_order/{id}', [CartController::class, 'remove_order']);

Route::get('/charts', [AdminController::class, 'charts']);
Route::get('/category_chart', [AdminController::class, 'category_Chart']);
Route::get('/content', [AdminController::class, 'content']);

Route::get('/order', [AdminController::class,'order']);

Route::get('view_faq', [HomeController::class, 'view_faq']);

Route::get('/pay', [PayController::class, 'stk']);
Route::post('/mpesa/confirmation', [PayController::class, 'confirmation']);
Route::get('/mpesapay', [PayController::class, 'mpesapay']);
Route::get('/lipampesa',[CartController::class, 'lipampesa']);
