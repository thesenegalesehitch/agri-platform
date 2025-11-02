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

        // Vérifier que le produit est actif
        if (!$product->is_active) {
            return back()->withErrors(['error' => 'Ce produit n\'est plus disponible.']);
        }

        // Vérifier le stock disponible
        $qty = $request->integer('quantity', 1);
        $cart = session('cart', []);
        $qtyInCart = $cart[$product->id] ?? 0;
        $totalQty = $qtyInCart + $qty;

        if ($totalQty > $product->stock) {
            return back()->withErrors([
                'error' => 'Stock insuffisant. Stock disponible: ' . $product->stock . ', déjà dans le panier: ' . $qtyInCart . ', demandé: ' . $totalQty
            ]);
        }

        $cart[$product->id] = $totalQty;
        session(['cart' => $cart]);
        
        return back()->with('status', 'Produit ajouté au panier (Quantité: ' . $totalQty . ')');
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
        if (empty($cart)) return back()->withErrors(['cart' => 'Panier vide']);

        $order = null;
        DB::transaction(function () use ($cart, &$order) {
            $order = Order::create([
                'buyer_id' => Auth::id(),
                'status' => 'pending',
                'total' => 0,
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
                // Ne pas décrementer le stock pour l'instant, on attendra le paiement
            }
            $order->update(['total' => $total]);
        });

        // Sauvegarder l'order_id en session pour la page de paiement
        session(['pending_order_id' => $order->id]);
        
        return redirect()->route('cart.payment', $order)->with('status', 'Sélectionnez votre mode de paiement');
    }

    public function showPayment(Order $order)
    {
        $this->authorize('view', $order);
        if ($order->buyer_id !== Auth::id()) {
            abort(403);
        }
        // Permettre l'accès si la commande peut encore être payée
        if (!in_array($order->status, ['pending', 'pending_payment', 'pending_validation'])) {
            return redirect()->route('orders.show', $order)->withErrors(['error' => 'Cette commande a déjà été traitée.']);
        }
        
        $order->load('items.product');
        return view('cart.payment', compact('order'));
    }

    public function processPayment(Request $request, Order $order)
    {
        $this->authorize('view', $order);
        if ($order->buyer_id !== Auth::id()) {
            abort(403);
        }
        // Permettre le paiement si la commande peut encore être payée
        if (!in_array($order->status, ['pending', 'pending_payment', 'pending_validation'])) {
            return back()->withErrors(['error' => 'Cette commande a déjà été traitée.']);
        }

        $request->validate([
            'payment_method' => ['required', 'in:wave,orange_money,cash,card,bank_transfer,mobile_money,paydunya'],
            'cash_payment_details' => ['required_if:payment_method,cash', 'nullable', 'string', 'max:1000'],
        ], [
            'payment_method.required' => 'Veuillez sélectionner un mode de paiement.',
            'payment_method.in' => 'Le mode de paiement sélectionné n\'est pas valide.',
            'cash_payment_details.required_if' => 'Veuillez fournir les détails du paiement en espèces.',
            'cash_payment_details.max' => 'Les détails du paiement ne peuvent pas dépasser 1000 caractères.',
        ]);

        try {
            DB::transaction(function () use ($request, $order) {
                // Charger les items avec les produits
                $order->load('items.product');

                // Vérifier le stock avant de continuer
                foreach ($order->items as $item) {
                    $product = $item->product;
                    if (!$product) {
                        throw new \Exception('Produit introuvable pour l\'item de commande #' . $item->id);
                    }
                    
                    // Recharger le produit pour avoir le stock à jour
                    $product->refresh();
                    
                    if ($product->stock < $item->quantity) {
                        throw new \Exception('Stock insuffisant pour le produit "' . $product->title . '". Stock disponible: ' . $product->stock . ', demandé: ' . $item->quantity);
                    }
                }

                // Mettre à jour la commande
                $order->update([
                    'payment_method' => $request->payment_method,
                    'cash_payment_details' => $request->cash_payment_details ?? null,
                    'status' => 'pending_payment', // Tous les paiements sont mis en attente
                ]);

                // Décrémenter le stock des produits de la commande
                foreach ($order->items as $item) {
                    $product = $item->product;
                    $product->decrement('stock', $item->quantity);
                }

                // Si paiement en espèces, notifier le producteur (hors transaction pour éviter les blocages)
                if ($request->payment_method === 'cash') {
                    // On notifie après la transaction pour éviter les problèmes
                }
            });

            // Notifications après la transaction (pour éviter les blocages)
            if ($request->payment_method === 'cash') {
                $this->notifyCashPayment($order);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erreur lors du traitement du paiement: ' . $e->getMessage()])->withInput();
        }

        session()->forget('cart');
        session()->forget('pending_order_id');

        $message = $request->payment_method === 'cash' 
            ? 'Votre demande de paiement en espèces a été envoyée au vendeur. La commande est en attente de confirmation.'
            : 'Votre paiement est en attente de traitement.';

        return redirect()->route('orders.show', $order)->with('status', $message);
    }

    private function notifyCashPayment(Order $order)
    {
        // Notifier tous les producteurs de la commande
        $producerIds = $order->items()->with('product.user')
            ->get()
            ->pluck('product.user_id')
            ->unique()
            ->filter();
        
        foreach ($producerIds as $producerId) {
            $producer = \App\Models\User::find($producerId);
            if ($producer) {
                $producer->notify(new \App\Notifications\CashPaymentRequested($order));
            }
        }
    }
}
