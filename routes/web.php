<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

// Language switcher route
Route::post('/language', [LanguageController::class, 'switch'])->name('language.switch');

// Login routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes with auth and language middleware
Route::middleware(['auth', 'language'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::get('/transactions/create', [TransactionsController::class, 'create'])
        ->name('transactions.create');
    Route::post('/transactions', [TransactionsController::class, 'store'])
        ->name('transactions.store');

    Route::get('/transactions/history', [TransactionsController::class, 'index'])
        ->name('transactions.history');
    Route::put('/transactions/{transaction}', [TransactionsController::class, 'update'])
        ->name('transactions.update');
    Route::delete('/transactions/{transaction}', [TransactionsController::class, 'destroy'])
        ->name('transactions.destroy');

    Route::get('/accounts/{account}/balance', [AccountsController::class, 'getBalance'])
        ->name('accounts.balance');
    Route::get('/accounts/{account}/statement', [AccountsController::class, 'statement'])
        ->name('accounts.statement');

    // Accounts resource routes
    Route::resource('accounts', AccountsController::class)->names('accounts');
    Route::post('/areas', [AreaController::class, 'store'])->name('areas.store');
    Route::put('/areas/{area}', [AreaController::class, 'update'])->name('areas.update');

    Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
    Route::get('/reports/print', [ReportsController::class, 'print'])->name('reports.print');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});
