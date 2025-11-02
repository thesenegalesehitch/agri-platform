@php
	use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">Paiement de la Commande #{{ $order->id }}</h2>
	</x-slot>

	<div class="max-w-4xl mx-auto">
		@if(session('status'))
			<div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
				{{ session('status') }}
			</div>
		@endif

		<!-- Récapitulatif de la commande -->
		<div class="content-card fade-in mb-6">
			<h3 class="section-title-agri mb-4">Récapitulatif de votre commande</h3>
			<div class="space-y-4">
				@foreach($order->items as $item)
					<div class="flex items-center justify-between border-b border-[#d0c9c0] pb-3">
						<div class="flex items-center gap-4 flex-1">
							@if($item->product->images && $item->product->images->count())
								@php $primaryImage = $item->product->images->firstWhere('is_primary', 1) ?? $item->product->images->first(); @endphp
								<img 
									src="{{ $primaryImage->url }}" 
									alt="{{ $item->product->title }}" 
									class="w-16 h-16 object-cover rounded-lg"
									loading="lazy"
									decoding="async"
									width="64"
									height="64"
								>
							@else
								<div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center">
									<span class="text-xl">🌾</span>
								</div>
							@endif
							<div class="flex-1">
								<h4 class="font-semibold text-[#5c4033]">{{ $item->product->title }}</h4>
								<p class="text-sm text-[#55493f]">
									{{ number_format($item->unit_price * 655.957, 0, ',', ' ') }} FCFA × {{ $item->quantity }}
								</p>
							</div>
						</div>
						<div class="text-right">
							<span class="font-bold text-[#4CAF50]">
								{{ number_format($item->total * 655.957, 0, ',', ' ') }} FCFA
							</span>
						</div>
					</div>
				@endforeach
			</div>
			<div class="mt-4 pt-4 border-t-2 border-[#5c4033]">
				<div class="flex justify-between items-center">
					<span class="text-xl font-semibold text-[#5c4033]">Total:</span>
					<span class="text-2xl font-bold text-[#4CAF50]">
						{{ number_format($order->total * 655.957, 0, ',', ' ') }} FCFA
					</span>
				</div>
			</div>
		</div>

		<!-- Formulaire de paiement -->
		<div class="content-card fade-in">
			<h3 class="section-title-agri mb-4">Sélectionnez votre mode de paiement</h3>
			
			<form method="POST" action="{{ route('cart.payment.process', $order) }}" id="paymentForm">
				@csrf
				
				<div class="space-y-4 mb-6">
					<!-- Wave -->
					<label class="flex items-start p-4 border-2 border-[#d0c9c0] rounded-lg cursor-pointer hover:border-[#4CAF50] transition-colors payment-option">
						<input type="radio" name="payment_method" value="wave" class="mt-1 mr-3 payment-method" required>
						<div class="flex-1">
							<div class="flex items-center gap-2 mb-1">
								<span class="text-2xl">🌊</span>
								<span class="font-semibold text-[#5c4033] text-lg">Wave</span>
							</div>
							<p class="text-sm text-[#55493f]">Payer via votre compte Wave</p>
						</div>
					</label>

					<!-- Orange Money -->
					<label class="flex items-start p-4 border-2 border-[#d0c9c0] rounded-lg cursor-pointer hover:border-[#FF6600] transition-colors payment-option">
						<input type="radio" name="payment_method" value="orange_money" class="mt-1 mr-3 payment-method" required>
						<div class="flex-1">
							<div class="flex items-center gap-2 mb-1">
								<span class="text-2xl">🟠</span>
								<span class="font-semibold text-[#5c4033] text-lg">Orange Money</span>
							</div>
							<p class="text-sm text-[#55493f]">Payer via votre compte Orange Money</p>
						</div>
					</label>

					<!-- Carte Bancaire -->
					<label class="flex items-start p-4 border-2 border-[#d0c9c0] rounded-lg cursor-pointer hover:border-[#1E88E5] transition-colors payment-option">
						<input type="radio" name="payment_method" value="card" class="mt-1 mr-3 payment-method" required>
						<div class="flex-1">
							<div class="flex items-center gap-2 mb-1">
								<span class="text-2xl">💳</span>
								<span class="font-semibold text-[#5c4033] text-lg">Carte Bancaire</span>
							</div>
							<p class="text-sm text-[#55493f]">Payer par carte bancaire (Visa, Mastercard)</p>
						</div>
					</label>

					<!-- Virement Bancaire -->
					<label class="flex items-start p-4 border-2 border-[#d0c9c0] rounded-lg cursor-pointer hover:border-[#4CAF50] transition-colors payment-option">
						<input type="radio" name="payment_method" value="bank_transfer" class="mt-1 mr-3 payment-method" required>
						<div class="flex-1">
							<div class="flex items-center gap-2 mb-1">
								<span class="text-2xl">🏦</span>
								<span class="font-semibold text-[#5c4033] text-lg">Virement Bancaire</span>
							</div>
							<p class="text-sm text-[#55493f]">Effectuer un virement bancaire</p>
						</div>
					</label>

					<!-- Espèces -->
					<label class="flex items-start p-4 border-2 border-[#d0c9c0] rounded-lg cursor-pointer hover:border-[#FF9800] transition-colors payment-option">
						<input type="radio" name="payment_method" value="cash" class="mt-1 mr-3 payment-method" required>
						<div class="flex-1">
							<div class="flex items-center gap-2 mb-1">
								<span class="text-2xl">💵</span>
								<span class="font-semibold text-[#5c4033] text-lg">Espèces</span>
							</div>
							<p class="text-sm text-[#55493f]">Payer en espèces à la livraison</p>
						</div>
					</label>
				</div>

				<!-- Champ pour les détails du paiement en espèces -->
				<div id="cashDetails" class="hidden mb-6">
					<label for="cash_payment_details" class="form-label-agri">
						Détails du paiement en espèces *
					</label>
					<textarea 
						name="cash_payment_details" 
						id="cash_payment_details" 
						rows="4" 
						class="form-input-agri" 
						placeholder="Veuillez indiquer les détails de votre paiement en espèces (lieu de rencontre, date prévue, etc.)"
					></textarea>
					<p class="text-sm text-[#55493f] mt-2">
						Cette information sera envoyée au vendeur pour organiser la livraison et le paiement.
					</p>
					@error('cash_payment_details')
						<p class="text-red-600 text-sm mt-1">{{ $message }}</p>
					@enderror
				</div>

				<!-- Champ pour les autres méthodes de paiement (pour future intégration) -->
				<div id="otherPaymentDetails" class="hidden mb-6">
					<div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
						<p class="text-blue-800 text-sm">
							<strong>Note:</strong> L'intégration des paiements électroniques sera disponible prochainement. 
							Pour l'instant, votre commande sera mise en attente et vous serez contacté pour finaliser le paiement.
						</p>
					</div>
				</div>

				@if($errors->any())
					<div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
						<ul class="list-disc list-inside text-red-600 text-sm space-y-1">
							@foreach($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif

				<div class="flex gap-4">
					<button type="submit" class="btn-primary-agri flex-1" style="padding: 1rem;">
						💳 Confirmer le Paiement
					</button>
					<a href="{{ route('cart.index') }}" class="btn-secondary-agri" style="padding: 1rem;">
						← Retour au Panier
					</a>
				</div>
			</form>
		</div>
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const paymentMethods = document.querySelectorAll('.payment-method');
			const cashDetails = document.getElementById('cashDetails');
			const cashDetailsTextarea = document.getElementById('cash_payment_details');
			const otherPaymentDetails = document.getElementById('otherPaymentDetails');

			paymentMethods.forEach(method => {
				method.addEventListener('change', function() {
					const value = this.value;
					
					// Afficher/masquer les champs selon la méthode choisie
					if (value === 'cash') {
						cashDetails.classList.remove('hidden');
						cashDetailsTextarea.required = true;
						otherPaymentDetails.classList.add('hidden');
					} else {
						cashDetails.classList.add('hidden');
						cashDetailsTextarea.required = false;
						cashDetailsTextarea.value = '';
						
						// Afficher le message pour les autres méthodes
						if (value === 'wave' || value === 'orange_money' || value === 'card' || value === 'bank_transfer') {
							otherPaymentDetails.classList.remove('hidden');
						} else {
							otherPaymentDetails.classList.add('hidden');
						}
					}
				});
			});

			// Initialiser l'état au chargement
			const selectedMethod = document.querySelector('.payment-method:checked');
			if (selectedMethod) {
				selectedMethod.dispatchEvent(new Event('change'));
			}
		});
	</script>
</x-app-layout>

