<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\FollowupController;
use App\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Route;

// ── Routes (Static UI Demo) ────────────────────────────────────────────

// Auth (Static Mock)
Route::get('/login', [LoginController::class , 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class , 'login']);

Route::get('/register', [RegisterController::class , 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class , 'register']);

Route::get('/forgot-password', [ForgotPasswordController::class , 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class , 'sendResetLinkEmail'])->name('password.email');

Route::post('/logout', [LoginController::class , 'logout'])->name('logout');

// Redirect root → dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class , 'index'])->name('dashboard');

// Leads (full CRUD - static)
Route::resource('leads', LeadController::class);

// Customers
Route::resource('customers', CustomerController::class)->only(['index', 'show', 'create', 'edit', 'store', 'update', 'destroy']);

// Follow-ups
Route::get('/followups/all', [FollowupController::class , 'all'])->name('followups.all');
Route::get('/followups/calendar', [FollowupController::class , 'calendar'])->name('followups.calendar');
Route::resource('followups', FollowupController::class)->except(['show']);

// Deals
Route::resource('deals', DealController::class);

// Activity Log
Route::get('/activity', [ActivityLogController::class , 'index'])->name('activity.index');
Route::put('/activity/{id}', [ActivityLogController::class , 'update'])->name('activity.update');
Route::delete('/activity/{id}', [ActivityLogController::class , 'destroy'])->name('activity.destroy');

// Notifications
Route::prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [NotificationController::class , 'index'])->name('index');
    Route::post('/mark-all', [NotificationController::class , 'markAllRead'])->name('markAllRead');
    Route::post('/{notification}/mark-read', [NotificationController::class , 'markRead'])->name('markRead');
    Route::delete('/{notification}', [NotificationController::class , 'destroy'])->name('destroy');
});

// Settings
Route::get('/settings', [SettingsController::class , 'index'])->name('settings.index');
Route::put('/settings', [SettingsController::class , 'update'])->name('settings.update');

// Users & Roles management
Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class , 'index'])->name('index');
    Route::post('/', [UserController::class , 'store'])->name('store');
    Route::put('/{user}', [UserController::class , 'update'])->name('update');
    Route::delete('/{user}', [UserController::class , 'destroy'])->name('destroy');

    // Roles sub-page
    Route::get('/roles', [UserController::class , 'roles'])->name('roles');
    Route::post('/roles', [UserController::class , 'storeRole'])->name('roles.store');
    Route::delete('/roles/{role}', [UserController::class , 'destroyRole'])->name('roles.destroy');
});
