<x-app-layout>
	<x-slot name="header"><h2 class="font-semibold text-xl">Mes Commandes</h2></x-slot>
	<div class="p-6">
		<form method="GET" class="mb-4 flex items-center space-x-2">
			<select name="status" class="border p-2">
				<option value="">Statut</option>
				@foreach(['pending','paid','cancelled','completed'] as $st)
					<option value="{{ $st }}" {{ request('status')===$st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
				@endforeach
			</select>
			<input type="date" name="from" value="{{ request('from') }}" class="border p-2" />
			<input type="date" name="to" value="{{ request('to') }}" class="border p-2" />
			<button class="px-3 py-2 bg-gray-800 text-white rounded">Filtrer</button>
		</form>
		<table class="min-w-full bg-white">
			<thead><tr><th class="p-2 text-left">#</th><th class="p-2">Total</th><th class="p-2">Statut</th></tr></thead>
			<tbody>
			@foreach($orders as $order)
				<tr class="border-t">
					<td class="p-2"><a class="text-blue-600" href="{{ route('orders.show',$order) }}">#{{ $order->id }}</a></td>
					<td class="p-2">{{ number_format($order->total * 655.957, 0, ',', ' ') }} FCFA</td>
					<td class="p-2">{{ $order->status }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<div class="mt-4">{{ $orders->links() }}</div>
	</div>
</x-app-layout>
