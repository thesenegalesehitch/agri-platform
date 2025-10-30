<x-app-layout>
	<x-slot name="header"><h2 class="font-semibold text-xl">Commande #{{ $order->id }}</h2></x-slot>
	<div class="p-6 bg-white shadow rounded max-w-3xl mx-auto">
		<p class="mb-2">Statut: {{ $order->status }}</p>
		<p class="mb-4">Total: {{ number_format($order->total * 655.957, 0, ',', ' ') }} FCFA</p>
		<div>
			<h3 class="font-semibold mb-2">Articles</h3>
			<ul class="list-disc pl-5">
			@foreach($order->items as $item)
				<li>{{ $item->product->title }} x {{ $item->quantity }} — {{ number_format($item->total * 655.957, 0, ',', ' ') }} FCFA</li>
			@endforeach
			</ul>
		</div>
	</div>
</x-app-layout>
