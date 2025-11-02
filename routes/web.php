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
Route::get('equipment', [EquipmentController::class, 'index'])->name('equipment.index');

// IMPORTANT: Les routes avec paramètres ({product}, {equipment}) doivent être définies 
// APRÈS toutes les routes spécifiques (create, edit) pour éviter les conflits de matching
// Ajout de contraintes pour exclure "create" et "edit" des valeurs possibles
Route::get('products/{product}', [ProductController::class, 'show'])
    ->where('product', '^(?!create|edit).*')
    ->name('products.show');
Route::get('equipment/{equipment}', [EquipmentController::class, 'show'])
    ->where('equipment', '^(?!create|edit).*')
    ->name('equipment.show');

// Routes d'autocomplétion (publiques)
Route::get('api/search/products', [\App\Http\Controllers\SearchController::class, 'autocompleteProducts'])->name('api.search.products');
Route::get('api/search/equipment', [\App\Http\Controllers\SearchController::class, 'autocompleteEquipment'])->name('api.search.equipment');
Route::get('api/search/locations', [\App\Http\Controllers\SearchController::class, 'autocompleteLocations'])->name('api.search.locations');

Route::middleware(['auth', 'suspended'])->group(function () {
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

	// Producer - IMPORTANT: définir create/edit AVANT les routes show avec paramètres
	Route::middleware('role:producer')->group(function () {
		// Définir create et edit explicitement pour éviter les conflits avec products/{product}
		// Utiliser ->name() APRÈS ->middleware() pour s'assurer que la route est bien nommée
		Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
		Route::post('products', [ProductController::class, 'store'])->name('products.store');
		Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
		Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
		Route::patch('products/{product}', [ProductController::class, 'update']);
		Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
	});

	// Equipment owner - IMPORTANT: définir create/edit AVANT les routes show avec paramètres
	Route::middleware('role:equipment_owner')->group(function () {
		// Définir create et edit explicitement AVANT le resource pour éviter les conflits
		Route::get('equipment/create', [EquipmentController::class, 'create'])->name('equipment.create');
		Route::post('equipment', [EquipmentController::class, 'store'])->name('equipment.store');
		Route::get('equipment/{equipment}/edit', [EquipmentController::class, 'edit'])->name('equipment.edit');
		Route::put('equipment/{equipment}', [EquipmentController::class, 'update'])->name('equipment.update');
		Route::patch('equipment/{equipment}', [EquipmentController::class, 'update']);
		Route::delete('equipment/{equipment}', [EquipmentController::class, 'destroy'])->name('equipment.destroy');
		
		Route::resource('rentals', RentalController::class)->only(['index','show','update']);
	});

	// Buyer
	Route::middleware('role:buyer')->group(function () {
		Route::get('cart', [CartController::class, 'index'])->name('cart.index');
		Route::post('cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
		Route::post('cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
		Route::post('checkout', [CartController::class, 'checkout'])->name('cart.checkout');
		Route::get('orders/{order}/payment', [CartController::class, 'showPayment'])->name('cart.payment');
		Route::post('orders/{order}/payment', [CartController::class, 'processPayment'])->name('cart.payment.process');
		Route::resource('orders', OrderController::class)->only(['index','show']);
		Route::post('orders/{order}/cancel', [OrderController::class, 'requestCancellation'])->name('orders.cancel.request');
	});

	// Rentals for buyers (request booking)
	Route::post('equipment/{equipment}/rent', [RentalController::class, 'store'])->name('rentals.store');

	// Images upload/delete/reorder (owner only)
	Route::post('images', [ImageController::class, 'store'])->name('images.store');
	Route::delete('images/{image}', [ImageController::class, 'destroy'])->name('images.destroy');
	Route::patch('images/reorder', [ImageController::class, 'reorder'])->name('images.reorder');

	// Suspension requests
	Route::resource('suspension-requests', SuspensionRequestController::class)->only(['index','create','store','show']);

	// Admin - IMPORTANT: définir create/edit AVANT les routes show avec paramètres
	Route::middleware('role:admin')->group(function () {
		Route::get('/admin', [DashboardController::class, 'admin'])->name('admin.dashboard');
		
		// Définir les routes users explicitement pour éviter les conflits avec /admin/users/{user}
		Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users.index');
		Route::get('/admin/users/create', [UserManagementController::class, 'create'])->name('admin.users.create');
		Route::post('/admin/users', [UserManagementController::class, 'store'])->name('admin.users.store');
		Route::get('/admin/users/{user}', [UserManagementController::class, 'show'])->name('admin.users.show');
		Route::get('/admin/users/{user}/edit', [UserManagementController::class, 'edit'])->name('admin.users.edit');
		Route::put('/admin/users/{user}', [UserManagementController::class, 'update'])->name('admin.users.update');
		Route::patch('/admin/users/{user}', [UserManagementController::class, 'update']);
		Route::delete('/admin/users/{user}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');
		
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
		
		// Gestion des demandes d'annulation de commandes
		Route::get('/admin/orders/cancellations', [\App\Http\Controllers\Admin\OrderCancellationController::class, 'index'])->name('admin.orders.cancellations.index');
		Route::get('/admin/orders/cancellations/{order}', [\App\Http\Controllers\Admin\OrderCancellationController::class, 'show'])->name('admin.orders.cancellations.show');
		Route::post('/admin/orders/cancellations/{order}/approve', [\App\Http\Controllers\Admin\OrderCancellationController::class, 'approve'])->name('admin.orders.cancellations.approve');
		Route::post('/admin/orders/cancellations/{order}/reject', [\App\Http\Controllers\Admin\OrderCancellationController::class, 'reject'])->name('admin.orders.cancellations.reject');
	});
});

require __DIR__.'/auth.php';
require __DIR__.'/profile.php';
