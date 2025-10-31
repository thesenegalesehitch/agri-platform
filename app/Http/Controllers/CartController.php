<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\OrderPaid;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('cart.index', ['cart' => $cart]);
    }

    public function add(Product $product, Request $request)
    {
        $request->validate([
            'quantity' => ['nullable','integer','min:1','max:100']
        ]);

        $cart = session('cart', []);
        $qty = $request->integer('quantity', 1);
        $cart[$product->id] = ($cart[$product->id] ?? 0) + $qty;
        session(['cart' => $cart]);
        return back()->with('status', 'Produit ajouté au panier');
    }

    public function remove(Product $product)
    {
        $cart = session('cart', []);
        unset($cart[$product->id]);
        session(['cart' => $cart]);
        return back()->with('status', 'Produit retiré du panier');
    }

    public function checkout(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) return back()->with('status', 'Panier vide');

        DB::transaction(function () use ($cart, &$order) {
            $order = Order::create([
                'buyer_id' => Auth::id(),
                'status' => 'paid',
                'total' => 0,
                'paid_at' => now(),
            ]);

            $total = 0;
            foreach ($cart as $productId => $qty) {
                $product = Product::findOrFail($productId);
                $qty = max(1, min(max(1, $qty), $product->stock));
                $lineTotal = $qty * $product->price;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_price' => $product->price,
                    'total' => $lineTotal,
                ]);
                $total += $lineTotal;
                $product->decrement('stock', $qty);
            }
            $order->update(['total' => $total]);
        });

        session()->forget('cart');
        // Notify buyer
        Auth::user()->notify(new OrderPaid($order));
        return redirect()->route('orders.show', $order)->with('status', 'Commande payée');
    }
}
