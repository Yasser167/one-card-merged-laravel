<?php

use App\Http\Controllers\auth\ForgotPasswordController;
use App\Http\Controllers\auth\ResetPasswordController;
use App\Http\Controllers\auth\UserController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\setting\SettingController;
use App\Http\Controllers\admin\SocialIconController;
use App\Http\Controllers\StoreController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;


Route::get('/change-language', [StoreController::class, 'languageGet']);
Route::post('/change-language', [StoreController::class, 'language'])->name('change.language');

Route::get('logout', [DashboardController::class, 'indexLogout']);

Route::get('email/verify', [UserController::class, 'getVerifyEmail'])->name('getVerifyEmail.notice');
Route::post('email/verify', [UserController::class, 'resendVerifyEmail'])->name('verification.notice');
Route::post('email/verify/otp', [UserController::class, 'verificationVerify'])->name('verification.verify');


Route::get('/', [StoreController::class, 'index'])->name('index.store');
Route::get('/product/{link}', [StoreController::class, 'show'])->name('store.show');
Route::get('/product-cart/{id}', [StoreController::class, 'showCart']);

Route::get('/purchase/complete', [StoreController::class, 'purchaseNotFound'])->name('purchase.complete');
Route::post('/purchase/complete', [StoreController::class, 'purchaseComplete'])->name('purchase.complete.add');

// Routes accessible only if the user is not logged in
Route::middleware(['web', 'guest'])->group(function () {
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::post('/login', [UserController::class, 'loginUser'])->name('user.login');

    Route::get('register', [UserController::class, 'register'])->name('register');
    Route::post('register', [UserController::class, 'store'])->name('user.store');

    Route::get('password/email', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('forgot');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('password/reset', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});


Route::middleware(['web', 'auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('index.dashboard');

    Route::post('logout', [DashboardController::class, 'logout'])->name('logout_user');

    Route::get('dashboard-settings', [DashboardController::class, 'settings'])->name('index.settings');
    Route::delete('dashboard/sessions/delete-other', [DashboardController::class, 'deleteOtherSessions'])->name('dashboard.sessions.clear');

    Route::put('dashboard-account-update', [DashboardController::class, 'accountUpdate'])->name('account.update');
    Route::put('dashboard-account-password-update', [DashboardController::class, 'accountPasswordUpdate'])->name('account.password.update');
});


Route::middleware(['web', 'auth', 'verified', AdminMiddleware::class])->group(function () {
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings');
    Route::put('/settings/{id}', [SettingController::class, 'update'])->name('admin.update.settings');

    Route::get('admin-socialIcon', [SocialIconController::class, 'index'])->name('socialIcon.show');
    Route::post('admin-socialIcon', [SocialIconController::class, 'store'])->name('socialIcon.store');
    Route::put('admin-socialIcon/{id}', [SocialIconController::class, 'update'])->name('socialIcon.update');
    Route::delete('admin-socialIcon/{id}', [SocialIconController::class, 'destroy'])->name('socialIcon.destroy');

    Route::get('admin-store', [StoreController::class, 'indexAdmin'])->name('admin.store.show');
    Route::get('admin-store-add', [StoreController::class, 'create'])->name('admin.store.add');
    Route::post('admin-store-add', [StoreController::class, 'store'])->name('admin.store.store');
    Route::get('admin-store-edit/{id}', [StoreController::class, 'edit'])->name('admin.store.edit');
    Route::put('admin-store-edit/{id}', [StoreController::class, 'update'])->name('admin.store.update');
    Route::delete('admin-store/{id}', [StoreController::class, 'destroy'])->name('admin.store.destroy');
});
