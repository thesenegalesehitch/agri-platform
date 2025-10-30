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

	public function admin()
	{
		return view('admin.index', [
			'users' => User::with('roles')->latest()->paginate(20),
		]);
	}

	public function suspend(User $user)
	{
		$user->update(['is_suspended' => true]);
		return back()->with('status', 'Utilisateur suspendu');
	}

	public function reactivate(User $user)
	{
		$user->update(['is_suspended' => false]);
		return back()->with('status', 'Utilisateur réactivé');
	}
}
