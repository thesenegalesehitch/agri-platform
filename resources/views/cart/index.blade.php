<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">Mon Panier</h2>
	</x-slot>

	@php
		use Illuminate\Support\Facades\Storage;
	@endphp

	<div class="content-card fade-in">
		@php
			$cart = session('cart', []);
			$products = App\Models\Product::whereIn('id', array_keys($cart))->get();
			$total = 0;
		@endphp

		@if(count($cart) > 0)
			<div class="space-y-4">
				@foreach($products as $product)
					@php
						$quantity = $cart[$product->id] ?? 0;
						$subtotal = $product->price * $quantity;
						$total += $subtotal;
					@endphp
					<div class="border border-[#d0c9c0] rounded-lg p-4 flex items-center justify-between hover:shadow-md transition-shadow">
						<div class="flex items-center gap-4 flex-1">
							@if($product->images && $product->images->count())
								@php $primaryImage = $product->images->firstWhere('is_primary', 1) ?? $product->images->first(); @endphp
								<img 
									src="{{ Storage::url($primaryImage->path) }}" 
									alt="{{ $product->title }}" 
									class="w-20 h-20 object-cover rounded-lg"
									loading="lazy"
									decoding="async"
									width="80"
									height="80"
								>
							@else
								<div class="w-20 h-20 bg-green-100 rounded-lg flex items-center justify-center">
									<span class="text-2xl">🌾</span>
								</div>
							@endif
							<div class="flex-1">
								<h3 class="font-semibold text-[#5c4033] text-lg">{{ $product->title }}</h3>
								<p class="text-[#55493f] text-sm">{{ number_format($product->price * 655.957, 0, ',', ' ') }} FCFA / unité</p>
							</div>
							<div class="flex items-center gap-4">
								<span class="text-[#5c4033] font-semibold">Qté: {{ $quantity }}</span>
								<span class="text-[#4CAF50] font-bold">{{ number_format($subtotal * 655.957, 0, ',', ' ') }} FCFA</span>
								<form method="POST" action="{{ route('cart.remove', $product) }}" class="inline">
									@csrf
									<button type="submit" class="btn-danger-agri" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
										🗑️ Retirer
									</button>
								</form>
							</div>
						</div>
					</div>
				@endforeach
			</div>

			<div class="mt-6 pt-6 border-t border-[#d0c9c0]">
				<div class="flex justify-between items-center mb-4">
					<span class="text-xl font-semibold text-[#5c4033]">Total:</span>
					<span class="text-2xl font-bold text-[#4CAF50]">{{ number_format($total * 655.957, 0, ',', ' ') }} FCFA</span>
				</div>
				<form method="POST" action="{{ route('cart.checkout') }}" class="mt-4">
					@csrf
					<button type="submit" class="btn-primary-agri w-full" style="padding: 1rem;">
						💳 Passer la Commande
					</button>
				</form>
			</div>
		@else
			<div class="text-center py-12">
				<span class="text-6xl mb-4 block">🛒</span>
				<p class="text-[#55493f] text-lg mb-6">Votre panier est vide</p>
				<a href="{{ route('products.index') }}" class="btn-primary-agri">
					Découvrir les produits
				</a>
			</div>
		@endif
	</div>
</x-app-layout>

