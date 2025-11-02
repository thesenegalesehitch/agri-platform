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

		@if($order->cancellation_requested)
			<div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
				<p class="text-yellow-800 font-semibold mb-2">⏳ Demande d'annulation en attente</p>
				<p class="text-sm text-yellow-700">Votre demande d'annulation est en cours d'examen par un administrateur.</p>
				@if($order->cancellation_reason)
					<div class="mt-3 pt-3 border-t border-yellow-200">
						<p class="text-sm font-medium text-yellow-800">Votre raison:</p>
						<p class="text-sm text-yellow-700 mt-1">{{ $order->cancellation_reason }}</p>
					</div>
				@endif
			</div>
		@elseif($order->status !== 'cancelled' && $order->status !== 'completed')
			<div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
				<h4 class="font-semibold text-red-800 mb-3">Annuler cette commande</h4>
				<form method="POST" action="{{ route('orders.cancel.request', $order) }}" id="cancelForm">
					@csrf
					<div class="mb-4">
						<label for="cancellation_reason" class="form-label-agri">
							Raison de l'annulation <span class="text-red-600">*</span>
						</label>
						<textarea 
							name="cancellation_reason" 
							id="cancellation_reason" 
							rows="4" 
							class="form-input-agri" 
							placeholder="Expliquez pourquoi vous souhaitez annuler cette commande (minimum 10 caractères)"
							required
							minlength="10"
							maxlength="1000"
						></textarea>
						<p class="text-sm text-[#55493f] mt-1">Votre demande sera examinée par un administrateur.</p>
					</div>
					<button type="submit" class="btn-danger-agri" onclick="return confirm('Êtes-vous sûr de vouloir demander l\'annulation de cette commande ?')">
						❌ Demander l'annulation
					</button>
				</form>
			</div>
		@endif

		<div class="mt-6">
			<a href="{{ route('orders.index') }}" class="btn-secondary-agri">
				← Retour aux commandes
			</a>
		</div>
	</div>
</x-app-layout>
