<?php

use App\Http\Controllers\Api\V1\CampaignController as V1CampaignController;
use App\Http\Controllers\Api\V1\CategoryController as V1CategoryController;
use App\Http\Controllers\Api\V1\DonationController as V1DonationController;
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
use App\Http\Controllers\Master\CampaignController;
use App\Http\Controllers\Master\CategoryController;
use App\Http\Controllers\Master\FaqController;
use App\Http\Controllers\Master\RekeningController;
use App\Http\Controllers\Master\SliderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Reports\ReportDonasiController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Transactions\DonationController;
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

        Route::put('campaigns/status/{campaign}', [V1CampaignController::class, 'status'])->name('campaigns.status');
        Route::put('campaigns/recomendation/{campaign}', [V1CampaignController::class, 'recomendation'])->name('campaigns.recomendation');
        Route::put('campaigns/populer/{campaign}', [V1CampaignController::class, 'populer'])->name('campaigns.populer');
        Route::put('campaigns/restore/{campaign}', [V1CampaignController::class, 'restore'])->name('campaigns.restore');
        Route::resource('campaigns', V1CampaignController::class);

        Route::post('donations/getTotalNominalByStatus', [V1DonationController::class, 'getTotalNominalByStatus'])->name('donations.getTotalNominalByStatus');
        Route::post('donations/getTotalCountByStatus', [V1DonationController::class, 'getTotalCountByStatus'])->name('donations.getTotalCountByStatus');
        Route::post('donations/checkStatus', [V1DonationController::class, 'checkStatus'])->name('donations.checkStatus');
        Route::resource('donations', V1DonationController::class);
    });

    Route::prefix('core')->group(function () {
        Route::resource('permissions', PermissionController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::put('menus/reorder/{menu}', [MenuController::class, 'menuOrder'])->name('menus.order');
        Route::resource('menus', MenuController::class);
    });

    Route::prefix('master')->group(function () {
        Route::resource('sliders', SliderController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('campaigns', CampaignController::class);
        Route::resource('faqs', FaqController::class);
        Route::resource('rekenings', RekeningController::class);
    });

    Route::prefix('transaction')->group(function () {
        Route::resource('donations', DonationController::class);
    });

    Route::prefix('report')->group(function () {
        Route::get('donations', [ReportDonasiController::class, 'donations'])->name('report.donation');
        Route::get('donaturs', [ReportDonasiController::class, 'donaturs'])->name('report.donatur');
    });

    Route::prefix('moota')->group(function () {
        Route::get('rekenings', [SettingsController::class, 'rekening'])->name('moota.rekening');
    });

    Route::prefix('sim')->group(function () {
        Route::get('paket', [SettingsController::class, 'paket'])->name('sim.paket');
    });

    Route::prefix('settings')->group(function () {
        Route::post('ckeditor/upload', [SettingsController::class, 'ckEditorUpload'])->name('ckeditor.upload');
    });
});
