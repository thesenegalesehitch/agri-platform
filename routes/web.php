<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\SuspensionRequestController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\Admin\UserManagementController;

Route::get('/', function () { return view('welcome'); });
Route::get('/about', function () { return view('about'); })->name('about');
Route::get('/contact', function () { return view('contact'); })->name('contact');
Route::get('/support', function () { return view('support'); })->name('support');

// Route publique pour voir les équipements
Route::get('equipment', [EquipmentController::class, 'index'])->name('equipment.index');

// IMPORTANT: Les routes avec paramètres ({product}, {equipment}) doivent être définies 
// APRÈS toutes les routes spécifiques (create, edit) pour éviter les conflits de matching
// Ajout de contraintes pour exclure "create" et "edit" des valeurs possibles
Route::get('equipment/{equipment}', [EquipmentController::class, 'show'])
    ->where('equipment', '^(?!create|edit).*')
    ->name('equipment.show');

// Routes d'autocomplétion (publiques)
Route::get('api/search/equipment', [\App\Http\Controllers\SearchController::class, 'autocompleteEquipment'])->name('api.search.equipment');
Route::get('api/search/locations', [\App\Http\Controllers\SearchController::class, 'autocompleteLocations'])->name('api.search.locations');

Route::middleware(['auth', 'suspended'])->group(function () {
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

	// Equipment owner - IMPORTANT: définir create/edit AVANT les routes show avec paramètres
	Route::middleware('role:equipment_owner')->group(function () {
		// Définir create et edit explicitement AVANT le resource pour éviter les conflits
		Route::get('equipment/create', [EquipmentController::class, 'create'])->name('equipment.create');
		Route::post('equipment', [EquipmentController::class, 'store'])->name('equipment.store');
		Route::get('equipment/{equipment}/edit', [EquipmentController::class, 'edit'])->name('equipment.edit');
		Route::put('equipment/{equipment}', [EquipmentController::class, 'update'])->name('equipment.update');
		Route::patch('equipment/{equipment}', [EquipmentController::class, 'update']);
		Route::delete('equipment/{equipment}', [EquipmentController::class, 'destroy'])->name('equipment.destroy');

		Route::patch('rentals/{rental}', [RentalController::class, 'update'])->name('rentals.update');
		Route::put('rentals/{rental}', [RentalController::class, 'update']);
	});

	Route::get('rentals', [RentalController::class, 'index'])->name('rentals.index');
	Route::get('rentals/{rental}', [RentalController::class, 'show'])->name('rentals.show');

	// Demandes de location (producers)
	Route::post('equipment/{equipment}/rent', [RentalController::class, 'store'])
		->middleware('role:producer')
		->name('rentals.store');

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
		
	});
});

require __DIR__.'/auth.php';
require __DIR__.'/profile.php';
