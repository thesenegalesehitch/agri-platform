<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\SuspensionRequestController;

Route::middleware('auth:sanctum')->group(function () {
	Route::get('/user', function (Request $request) {
		return $request->user();
	});

	Route::middleware('role:equipment_owner')->apiResource('equipment', EquipmentController::class);
	Route::middleware('role:producer')->post('equipment/{equipment}/rent', [RentalController::class, 'store']);
	Route::get('rentals', [RentalController::class, 'index']);
	Route::get('rentals/{rental}', [RentalController::class, 'show']);
	Route::middleware('role:equipment_owner')->patch('rentals/{rental}', [RentalController::class, 'update']);
	Route::middleware('role:equipment_owner')->put('rentals/{rental}', [RentalController::class, 'update']);

	Route::post('suspension-requests', [SuspensionRequestController::class, 'store']);
});


