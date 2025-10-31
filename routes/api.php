<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\SuspensionRequestController;

Route::middleware('auth:sanctum')->group(function () {
	Route::get('/user', function (Request $request) {
		return $request->user();
	});

	Route::middleware('role:producer')->apiResource('products', ProductController::class);
	Route::middleware('role:equipment_owner')->apiResource('equipment', EquipmentController::class);
	Route::middleware('role:buyer')->group(function () {
		Route::get('orders', [OrderController::class, 'index']);
		Route::get('orders/{order}', [OrderController::class, 'show']);
	});

	Route::post('equipment/{equipment}/rent', [RentalController::class, 'store']);
	Route::get('rentals', [RentalController::class, 'index']);

	Route::post('suspension-requests', [SuspensionRequestController::class, 'store']);
});


