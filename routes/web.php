<?php

use App\Http\Controllers\Api\V1\CategoryController as V1CategoryController;
use App\Http\Controllers\Api\V1\FaqController as V1FaqController;
use App\Http\Controllers\Api\V1\MenuController as V1MenuController;
use App\Http\Controllers\Api\V1\PermissionController as V1PermissionController;
use App\Http\Controllers\Api\V1\RekeningController as V1RekeningController;
use App\Http\Controllers\Api\V1\RoleController as V1RoleController;
use App\Http\Controllers\Api\V1\SliderController as V1SliderController;
use App\Http\Controllers\Api\V1\UserController as V1UserController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Core\PermissionController;
use App\Http\Controllers\Core\RoleController;
use App\Http\Controllers\Core\UserController;
use App\Http\Controllers\Core\MenuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Master\CategoryController;
use App\Http\Controllers\Master\FaqController;
use App\Http\Controllers\Master\RekeningController;
use App\Http\Controllers\Master\SliderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/home');

Auth::routes(['register' => false]);

Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'googleRedirect'])->name('google.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'googleCallback'])->name('google.callback');

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::prefix('apis')->group(function () {
        Route::resource('permissions', V1PermissionController::class);
        Route::resource('roles', V1RoleController::class);
        Route::resource('users', V1UserController::class);
        Route::resource('menus', V1MenuController::class);
        Route::resource('sliders', V1SliderController::class);

        Route::put('categories/populer/{category}', [V1CategoryController::class, 'populer'])->name('categories.populer');
        Route::put('categories/status/{category}', [V1CategoryController::class, 'status'])->name('categories.status');
        Route::put('categories/restore/{category}', [V1CategoryController::class, 'restore'])->name('categories.restore');
        Route::resource('categories', V1CategoryController::class);

        Route::put('faqs/status/{faq}', [V1FaqController::class, 'status'])->name('faqs.status');
        Route::put('faqs/restore/{faq}', [V1FaqController::class, 'restore'])->name('faqs.restore');
        Route::resource('faqs', V1FaqController::class);

        Route::put('rekenings/populer/{rekening}', [V1RekeningController::class, 'populer'])->name('rekenings.populer');
        Route::put('rekenings/status/{rekening}', [V1RekeningController::class, 'status'])->name('rekenings.status');
        Route::resource('rekenings', V1RekeningController::class);
    });

    Route::prefix('core')->group(function () {
        Route::resource('permissions', PermissionController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::resource('menus', MenuController::class);
    });

    Route::prefix('master')->group(function () {
        Route::resource('sliders', SliderController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('faqs', FaqController::class);
        Route::resource('rekenings', RekeningController::class);
    });

    Route::prefix('moota')->group(function () {
        Route::get('rekenings', [SettingsController::class, 'rekening'])->name('moota.rekening');
    });

    Route::prefix('settings')->group(function () {
        Route::post('ckeditor/upload', [SettingsController::class, 'ckEditorUpload'])->name('ckeditor.upload');
    });
});
