<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LendingController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('landing');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Group pages untuk admin saja
Route::group(['middleware' => ['auth', 'role:admin'], 'prefix' => 'admin'], function () {
    // Halaman Dashboard Admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // CRUD Halaman Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/categories/export', [CategoryController::class, 'export'])->name('admin.categories.export');
    Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // CRUD Halaman Items
    Route::get('/items', [ItemController::class, 'index'])->name('admin.items.index');
    Route::get('/items/export', [ItemController::class, 'exportExcel'])->name('admin.items.export');
    Route::post('/items', [ItemController::class, 'store'])->name('admin.items.store');
    Route::put('/items/{item}', [ItemController::class, 'update'])->name('admin.items.update');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('admin.items.destroy');
    Route::get('/items/{item}/lending', [LendingController::class, 'showItemLendings'])->name('admin.items.lending');
    Route::delete('/items/lending/{lending}', [LendingController::class, 'destroy'])->name('admin.items.lending.destroy');

    // User Management Routes
    Route::get('/users/admin', [UserController::class, 'indexAdmin'])->name('admin.users.admin');
    Route::get('/users/operator', [UserController::class, 'indexOperator'])->name('admin.users.operator');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/export', [UserController::class, 'exportExcel'])->name('admin.users.export');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::patch('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('admin.users.reset-password');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

// Group pages untuk staff saja
Route::group(['middleware' => ['auth', 'role:staff'], 'prefix' => 'staff'], function () {
    Route::get('/dashboard', function () {
        return view('staff.dashboard');
    })->name('staff.dashboard');

    Route::get('/items', [ItemController::class, 'index'])->name('staff.items.index');
    
    // Lending Routes
    Route::get('/lending', [LendingController::class, 'index'])->name('staff.lending.index');
    Route::get('/lending/export', [LendingController::class, 'exportExcel'])->name('staff.lending.export');
    Route::post('/lending', [LendingController::class, 'store'])->name('staff.lending.store');
    Route::patch('/lending/{lending}/return', [LendingController::class, 'returnItem'])->name('staff.lending.return');
    Route::delete('/lending/{lending}', [LendingController::class, 'destroy'])->name('staff.lending.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('staff.profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('staff.profile.update');
});
