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
}
