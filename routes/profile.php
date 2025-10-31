<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
	
	// Vérification téléphone
	Route::post('/profile/send-phone-code', [ProfileController::class, 'sendPhoneVerificationCode'])->name('profile.send-phone-code');
	Route::post('/profile/verify-phone', [ProfileController::class, 'verifyPhone'])->name('profile.verify-phone');
});
