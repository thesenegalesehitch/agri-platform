<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Equipment;
use App\Models\Order;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
	public function index()
	{
		$user = Auth::user();
		return view('dashboard.index', [
			'user' => $user,
			'productsCount' => $user->hasRole('producer') ? Product::where('user_id', $user->id)->count() : null,
			'equipmentCount' => $user->hasRole('equipment_owner') ? Equipment::where('user_id', $user->id)->count() : null,
			'ordersCount' => $user->hasRole('buyer') ? Order::where('buyer_id', $user->id)->count() : null,
			'rentalsCount' => $user->hasRole('equipment_owner') ? Rental::whereHas('equipment', fn ($q) => $q->where('user_id', $user->id))->count() : null,
		]);
	}

	public function admin(Request $request)
	{
		$filter = $request->input('filter', 'all');
		$query = User::with('roles');

		if ($filter === 'suspended') {
			$query->where('is_suspended', true);
		} elseif ($filter === 'active') {
			$query->where('is_suspended', false);
		} elseif ($filter === 'unverified_cni') {
			$query->whereNotNull('cni_recto_path')
			      ->whereNotNull('cni_verso_path')
			      ->where('cni_verified', false);
		}

		$users = $query->latest()->paginate(20)->withQueryString();

		$stats = [
			'total' => User::count(),
			'active' => User::where('is_suspended', false)->count(),
			'suspended' => User::where('is_suspended', true)->count(),
			'pending_cni' => User::whereNotNull('cni_recto_path')
				->whereNotNull('cni_verso_path')
				->where('cni_verified', false)
				->count(),
		];

		return view('admin.index', compact('users', 'filter', 'stats'));
	}

	public function suspend(User $user)
	{
		$user->update(['is_suspended' => true]);
		$redirectUrl = url()->previous();
		// Ajouter un fragment pour éviter de retourner en haut de la page
		if (strpos($redirectUrl, '#') === false) {
			$redirectUrl .= '#user-' . $user->id;
		}
		return redirect($redirectUrl)->with('status', 'Utilisateur suspendu avec succès');
	}

	public function reactivate(User $user)
	{
		$user->update(['is_suspended' => false]);
		$redirectUrl = url()->previous();
		// Ajouter un fragment pour éviter de retourner en haut de la page
		if (strpos($redirectUrl, '#') === false) {
			$redirectUrl .= '#user-' . $user->id;
		}
		return redirect($redirectUrl)->with('status', 'Utilisateur réactivé avec succès');
	}
}
