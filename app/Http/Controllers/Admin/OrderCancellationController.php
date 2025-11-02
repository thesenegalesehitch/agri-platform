<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderCancellationController extends Controller
{
    public function index()
    {
        $orders = Order::where('cancellation_requested', true)
            ->where('status', '!=', 'cancelled')
            ->with(['buyer', 'items.product'])
            ->latest('cancellation_requested_at')
            ->paginate(15);
        
        return view('admin.orders.cancellations.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if (!$order->cancellation_requested) {
            return redirect()->route('admin.orders.cancellations.index')
                ->withErrors(['error' => 'Cette commande n\'a pas de demande d\'annulation.']);
        }

        $order->load(['buyer', 'items.product']);
        return view('admin.orders.cancellations.show', compact('order'));
    }

    public function approve(Request $request, Order $order)
    {
        if (!$order->cancellation_requested) {
            return back()->withErrors(['error' => 'Cette commande n\'a pas de demande d\'annulation.']);
        }

        if ($order->status === 'cancelled') {
            return back()->withErrors(['error' => 'Cette commande est déjà annulée.']);
        }

        DB::transaction(function () use ($order) {
            // Annuler la commande
            $updateData = ['status' => 'cancelled'];
            if (Schema::hasColumn('orders', 'cancelled_at')) {
                $updateData['cancelled_at'] = now();
            }
            $order->update($updateData);

            // Restaurer le stock des produits
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }
        });

        // Notifier l'acheteur
        $order->buyer->notify(new \App\Notifications\OrderCancellationApproved($order));

        return redirect()->route('admin.orders.cancellations.index')
            ->with('status', 'La demande d\'annulation a été approuvée et la commande a été annulée.');
    }

    public function reject(Request $request, Order $order)
    {
        if (!$order->cancellation_requested) {
            return back()->withErrors(['error' => 'Cette commande n\'a pas de demande d\'annulation.']);
        }

        $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500', 'min:10'],
        ], [
            'rejection_reason.required' => 'Veuillez fournir une raison pour le rejet.',
            'rejection_reason.min' => 'La raison doit contenir au moins 10 caractères.',
            'rejection_reason.max' => 'La raison ne peut pas dépasser 500 caractères.',
        ]);

        DB::transaction(function () use ($request, $order) {
            // Rejeter la demande d'annulation
            $order->update([
                'cancellation_requested' => false,
                'cancellation_reason' => null,
                'cancellation_requested_at' => null,
            ]);
        });

        // Notifier l'acheteur avec la raison du rejet
        $order->buyer->notify(new \App\Notifications\OrderCancellationRejected($order, $request->rejection_reason));

        return redirect()->route('admin.orders.cancellations.index')
            ->with('status', 'La demande d\'annulation a été rejetée.');
    }
}
