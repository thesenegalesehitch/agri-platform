<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\SuspensionRequestController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\Admin\UserManagementController;

Route::get('/', function () { return view('welcome'); });
Route::get('/about', function () { return view('about'); })->name('about');
Route::get('/contact', function () { return view('contact'); })->name('contact');
Route::get('/support', function () { return view('support'); })->name('support');

Route::middleware(['auth', 'verified'])->group(function () {
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

	// Producer
	Route::middleware([
		\Spatie\Permission\Middleware\RoleMiddleware::class.':producer'
	])->group(function () {
		Route::resource('products', ProductController::class);
	});

	// Equipment owner
	Route::middleware([
		\Spatie\Permission\Middleware\RoleMiddleware::class.':equipment_owner'
	])->group(function () {
		Route::resource('equipment', EquipmentController::class);
		Route::resource('rentals', RentalController::class)->only(['index','show','update']);
	});

	// Buyer
	Route::middleware([
		\Spatie\Permission\Middleware\RoleMiddleware::class.':buyer'
	])->group(function () {
		Route::get('cart', [CartController::class, 'index'])->name('cart.index');
		Route::post('cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
		Route::post('cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
		Route::post('checkout', [CartController::class, 'checkout'])->name('cart.checkout');
		Route::resource('orders', OrderController::class)->only(['index','show']);
	});

	// Rentals for buyers (request booking)
	Route::post('equipment/{equipment}/rent', [RentalController::class, 'store'])->name('rentals.store');

	// Images upload/delete/reorder (owner only)
	Route::post('images', [ImageController::class, 'store'])->name('images.store');
	Route::delete('images/{image}', [ImageController::class, 'destroy'])->name('images.destroy');
	Route::patch('images/reorder', [ImageController::class, 'reorder'])->name('images.reorder');

	// Suspension requests
	Route::resource('suspension-requests', SuspensionRequestController::class)->only(['index','create','store','show']);

	// Admin
	Route::middleware([
		\Spatie\Permission\Middleware\RoleMiddleware::class.':admin'
	])->group(function () {
		Route::get('/admin', [DashboardController::class, 'admin'])->name('admin.dashboard');
		Route::resource('/admin/users', UserManagementController::class)->names('admin.users');
		Route::patch('/admin/users/{user}/suspend', [DashboardController::class, 'suspend'])->name('admin.users.suspend');
		Route::patch('/admin/users/{user}/reactivate', [DashboardController::class, 'reactivate'])->name('admin.users.reactivate');
		Route::patch('/admin/suspension-requests/{suspensionRequest}/approve', [SuspensionRequestController::class, 'approve'])->name('admin.suspensions.approve');
		Route::patch('/admin/suspension-requests/{suspensionRequest}/reject', [SuspensionRequestController::class, 'reject'])->name('admin.suspensions.reject');
	});
});

require __DIR__.'/auth.php';
require __DIR__.'/profile.php';
