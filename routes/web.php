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

// Routes publiques pour voir les produits et équipements
Route::get('products', [ProductController::class, 'index'])->name('products.index');
Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('equipment', [EquipmentController::class, 'index'])->name('equipment.index');
Route::get('equipment/{equipment}', [EquipmentController::class, 'show'])->name('equipment.show');

// Routes d'autocomplétion (publiques)
Route::get('api/search/products', [\App\Http\Controllers\SearchController::class, 'autocompleteProducts'])->name('api.search.products');
Route::get('api/search/equipment', [\App\Http\Controllers\SearchController::class, 'autocompleteEquipment'])->name('api.search.equipment');
Route::get('api/search/locations', [\App\Http\Controllers\SearchController::class, 'autocompleteLocations'])->name('api.search.locations');

Route::middleware(['auth', 'verified', 'suspended'])->group(function () {
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

	// Producer
	Route::middleware([
		\Spatie\Permission\Middleware\RoleMiddleware::class.':producer'
	])->group(function () {
		Route::resource('products', ProductController::class)->except(['index', 'show']);
	});

	// Equipment owner
	Route::middleware([
		\Spatie\Permission\Middleware\RoleMiddleware::class.':equipment_owner'
	])->group(function () {
		Route::resource('equipment', EquipmentController::class)->except(['index', 'show']);
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
		
		// Vérification CNI
		Route::get('/admin/cni', [\App\Http\Controllers\Admin\CniVerificationController::class, 'index'])->name('admin.cni.index');
		Route::get('/admin/cni/{user}', [\App\Http\Controllers\Admin\CniVerificationController::class, 'show'])->name('admin.cni.show');
		Route::post('/admin/cni/{user}/approve', [\App\Http\Controllers\Admin\CniVerificationController::class, 'approve'])->name('admin.cni.approve');
		Route::post('/admin/cni/{user}/reject', [\App\Http\Controllers\Admin\CniVerificationController::class, 'reject'])->name('admin.cni.reject');
		
		// Demandes de suspension/réactivation (gestion admin)
		Route::patch('/admin/suspension-requests/{suspensionRequest}/approve', [SuspensionRequestController::class, 'approve'])->name('admin.suspensions.approve');
		Route::patch('/admin/suspension-requests/{suspensionRequest}/reject', [SuspensionRequestController::class, 'reject'])->name('admin.suspensions.reject');
	});
});

require __DIR__.'/auth.php';
require __DIR__.'/profile.php';
