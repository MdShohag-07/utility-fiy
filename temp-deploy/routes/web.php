<?php

use Illuminate\Support\Facades\Route;

// --- Authentication Controllers ---
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\UserSignupController; // Your custom signup controller
use App\Http\Controllers\Auth\AdminLoginController;

// --- Page/Feature Controllers ---
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\ProfileController; // This can be used for both global and namespaced profile routes

// --- User Controllers ---
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserBillingController;
use App\Http\Controllers\User\UserServiceController;
// If you have a specific UserProfileController for /my-account/profile, import it here.
// Otherwise, the global ProfileController will be used.

// --- Admin Controllers ---
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\SiteSettingsController;
use App\Http\Controllers\Admin\HomepageController;
use App\Http\Controllers\Admin\MenuLinkController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\StatementController;
use App\Http\Controllers\Admin\BillingController as AdminBillingController;
use App\Http\Controllers\Admin\FooterController;
use App\Http\Controllers\Admin\PdfSettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Public Routes ---
Route::get('/', [PublicPageController::class, 'home'])->name('home');
Route::get('/forgot-username', [PublicPageController::class, 'forgotUsername'])->name('forgot.username');

// --- Guest Routes ---
Route::middleware('guest')->group(function () {
    Route::get('signup', [UserSignupController::class, 'create'])->name('signup');
    Route::post('signup', [UserSignupController::class, 'store'])->name('user.signup.store');
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('admin/login', [AdminLoginController::class, 'create'])->name('admin.login');
    Route::post('admin/login', [AdminLoginController::class, 'store']);
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

// --- Authenticated Routes (General) ---
Route::middleware('auth')->group(function () {
     Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
     Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
     Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')->name('verification.send');
     Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

     // --- General Profile Routes (Optional, if you need a /profile separate from /my-account/profile) ---
     // If all profile editing happens under /my-account, these can be removed to avoid confusion.
     // For now, keeping them to show they would have different names.
     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); // Name: 'profile.edit'
     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Name: 'profile.update'
     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Name: 'profile.destroy'
     // --- End General Profile Routes ---
});

// --- Authenticated AND Verified USER Routes (/my-account) ---
Route::middleware(['auth', 'verified'])
    ->prefix('my-account')
    ->name('my-account.') // Group name prefix, e.g., my-account.index
    ->group(function () {
        Route::get('/', [UserDashboardController::class, 'index'])->name('index'); // Full name: my-account.index

        // === PROFILE ROUTES WITHIN THE 'my-account' NAMESPACE ===
        // This makes route('my-account.profile.edit') valid.
        // URL will be /my-account/profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); // Full name: my-account.profile.edit
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Full name: my-account.profile.update
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Full name: my-account.profile.destroy
        // =======================================================

        Route::get('/statement', [UserDashboardController::class, 'showStatement'])->name('statement'); // Full name: my-account.statement
        Route::get('/statement/view', [UserDashboardController::class, 'viewStatement'])->name('statement.view'); // Full name: my-account.statement.view

        Route::get('/billing', [UserBillingController::class, 'index'])->name('billing.index');
        Route::get('/billing/statements', [UserBillingController::class, 'statements'])->name('billing.statements');
        Route::get('/billing/statements/{statement}', [UserBillingController::class, 'showStatementDetails'])
             ->name('billing.statement.showDetails')->where('statement', '[0-9]+');
        Route::get('/billing/statements/{statement}/download', [UserBillingController::class, 'downloadStatementPdf'])
            ->name('billing.statement.downloadPdf')->where('statement', '[0-9]+');

        Route::get('/services', [UserServiceController::class, 'index'])->name('services.index');
});

// --- Authenticated ADMIN Routes (/admin) ---
Route::middleware(['auth', \App\Http\Middleware\IsAdmin::class])
      ->prefix('admin')
      ->name('admin.')
      ->group(function () {
           Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
           Route::get('/settings/general', [SiteSettingsController::class, 'editGeneral'])->name('settings.general.edit');
           Route::patch('/settings/general', [SiteSettingsController::class, 'updateGeneral'])->name('settings.general.update');
           Route::get('/settings/pdf', [PdfSettingController::class, 'edit'])->name('settings.pdf.edit');
           Route::patch('/settings/pdf', [PdfSettingController::class, 'update'])->name('settings.pdf.update');

           Route::prefix('pages')->name('pages.')->group(function() {
                 Route::get('/homepage/edit', [HomepageController::class, 'edit'])->name('homepage.edit'); // admin.pages.homepage.edit
                 Route::patch('/homepage/hero', [HomepageController::class, 'updateHero'])->name('homepage.update.hero');
                 Route::patch('/homepage/account', [HomepageController::class, 'updateAccountSection'])->name('homepage.update.account');
                 Route::patch('/homepage/internet', [HomepageController::class, 'updateInternetSection'])->name('homepage.update.internet');
                 Route::patch('/homepage/resources', [HomepageController::class, 'updateResources'])->name('homepage.update.resources');
                 Route::patch('/homepage/features', [HomepageController::class, 'updateFeatures'])->name('homepage.update.features');
                 Route::patch('/homepage/careers', [HomepageController::class, 'updateCareers'])->name('homepage.update.careers');
                 Route::patch('/homepage/solutions', [HomepageController::class, 'updateSolutions'])->name('homepage.update.solutions');
                 Route::patch('/homepage/news', [HomepageController::class, 'updateNews'])->name('homepage.update.news');
            });

           Route::resource('menus', MenuLinkController::class)->parameters(['menus' => 'menuLink'])->except(['show']);
           Route::resource('users', AdminUserController::class)->except(['show']);

           Route::resource('statements', StatementController::class)
                ->parameters(['statements' => 'statement'])->except(['edit', 'update']);
           Route::get('statements/{statement}/download', [StatementController::class, 'downloadPdf'])
                ->name('statements.downloadPdf')->where('statement', '[0-9]+');

           Route::get('/billing', [AdminBillingController::class, 'index'])->name('billing.index');
           Route::get('/footer', [FooterController::class, 'edit'])->name('footer.edit');
           Route::patch('/footer', [FooterController::class, 'update'])->name('footer.update');
           Route::get('/users/link', [AdminUserController::class, 'showLinkForm'])->name('users.link.show');
           Route::post('/users/link', [AdminUserController::class, 'storeLink'])->name('users.link.store');
});