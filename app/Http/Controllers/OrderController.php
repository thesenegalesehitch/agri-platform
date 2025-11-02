<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
	{
        $query = Order::with('items.product')->where('buyer_id', Auth::id());
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->input('from'));
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->input('to'));
        }
        $orders = $query->latest()->paginate(12);
		return view('orders.index', compact('orders'));
	}

	public function show(Order $order)
	{
		$this->authorize('view', $order);
		$order->load('items.product');
		return view('orders.show', compact('order'));
	}

	public function requestCancellation(Request $request, Order $order)
	{
		$this->authorize('view', $order);
		if ($order->buyer_id !== Auth::id()) {
			abort(403);
		}

		// Vérifier que la commande peut être annulée
		if ($order->status === 'cancelled') {
			return back()->withErrors(['error' => 'Cette commande est déjà annulée.']);
		}

		if ($order->status === 'completed') {
			return back()->withErrors(['error' => 'Les commandes complétées ne peuvent pas être annulées.']);
		}

		if ($order->cancellation_requested) {
			return back()->withErrors(['error' => 'Une demande d\'annulation a déjà été soumise pour cette commande.']);
		}

		$request->validate([
			'cancellation_reason' => ['required', 'string', 'max:1000', 'min:10'],
		], [
			'cancellation_reason.required' => 'Veuillez fournir une raison pour l\'annulation.',
			'cancellation_reason.min' => 'La raison doit contenir au moins 10 caractères.',
			'cancellation_reason.max' => 'La raison ne peut pas dépasser 1000 caractères.',
		]);

		$order->update([
			'cancellation_requested' => true,
			'cancellation_reason' => $request->cancellation_reason,
			'cancellation_requested_at' => now(),
		]);

		// Notifier les admins (vous pouvez créer une notification si nécessaire)
		$admins = \App\Models\User::role('admin')->get();
		foreach ($admins as $admin) {
			$admin->notify(new \App\Notifications\OrderCancellationRequested($order));
		}

		return back()->with('status', 'Votre demande d\'annulation a été soumise et sera examinée par un administrateur.');
	}
}
