<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">Commande #{{ $order->id }}</h2>
	</x-slot>

	<div class="content-card fade-in max-w-3xl mx-auto">
		<div class="mb-6">
			<div class="flex justify-between items-center mb-4">
				<span class="text-[#55493f] font-medium">Statut:</span>
				<span class="px-4 py-2 rounded-full text-sm font-semibold
					@if($order->status === 'paid') bg-green-100 text-green-800
					@elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
					@elseif($order->status === 'cancelled') bg-red-100 text-red-800
					@else bg-blue-100 text-blue-800
					@endif">
					{{ ucfirst($order->status) }}
				</span>
			</div>
			<div class="flex justify-between items-center">
				<span class="text-[#55493f] font-medium">Total:</span>
				<span class="text-2xl font-bold text-[#4CAF50]">{{ number_format($order->total * 655.957, 0, ',', ' ') }} FCFA</span>
			</div>
		</div>

		<div class="border-t border-[#d0c9c0] pt-6 mt-6">
			<h3 class="section-title-agri">Articles</h3>
			<div class="space-y-3">
				@foreach($order->items as $item)
					<div class="flex items-center justify-between p-4 bg-[#f8f6f3] rounded-lg">
						<div>
							<p class="font-semibold text-[#5c4033]">{{ $item->product->title }}</p>
							<p class="text-sm text-[#55493f]">Quantité: {{ $item->quantity }}</p>
						</div>
						<span class="font-bold text-[#4CAF50]">{{ number_format($item->total * 655.957, 0, ',', ' ') }} FCFA</span>
					</div>
				@endforeach
			</div>
		</div>

		<div class="mt-6">
			<a href="{{ route('orders.index') }}" class="btn-secondary-agri">
				← Retour aux commandes
			</a>
		</div>
	</div>
</x-app-layout>
