<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ShoppingListController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/cocinado', [ItemController::class, 'cooked'])->name('items.cooked');
    Route::get('/sin-preparar', [ItemController::class, 'unprepared'])->name('items.unprepared');
    Route::get('/articulos', [ItemController::class, 'general'])->name('items.general');

    Route::resource('items', ItemController::class)->except(['show']);

    Route::get('/compras', [ShoppingListController::class, 'index'])->name('shopping-list.index');
    Route::patch('/compras/{item}/comprado', [ShoppingListController::class, 'markPurchased'])->name('shopping-list.purchased');
    Route::patch('/compras/comprado/todos', [ShoppingListController::class, 'markAllPurchased'])->name('shopping-list.purchased-all');
});
