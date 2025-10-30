<x-app-layout>
	<x-slot name="header"><h2 class="font-semibold text-xl">Mes Locations</h2></x-slot>
	<div class="p-6">
		<form method="GET" class="mb-4 flex items-center space-x-2">
			<select name="status" class="border p-2">
				<option value="">Statut</option>
				@foreach(['pending','approved','rejected','active','completed','cancelled'] as $st)
					<option value="{{ $st }}" {{ request('status')===$st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
				@endforeach
			</select>
			<input type="date" name="from" value="{{ request('from') }}" class="border p-2" />
			<input type="date" name="to" value="{{ request('to') }}" class="border p-2" />
			<button class="px-3 py-2 bg-gray-800 text-white rounded">Filtrer</button>
		</form>
		<table class="min-w-full bg-white">
			<thead><tr><th class="p-2 text-left">#</th><th class="p-2">Matériel</th><th class="p-2">Période</th><th class="p-2">Statut</th><th class="p-2">Total</th></tr></thead>
			<tbody>
			@foreach($rentals as $rental)
				<tr class="border-t">
					<td class="p-2">#{{ $rental->id }}</td>
					<td class="p-2">{{ optional($rental->equipment)->title }}</td>
					<td class="p-2">{{ $rental->start_date->format('Y-m-d') }} → {{ $rental->end_date->format('Y-m-d') }}</td>
					<td class="p-2">{{ $rental->status }}</td>
					<td class="p-2">{{ number_format($rental->total * 655.957, 0, ',', ' ') }} FCFA</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<div class="mt-4">{{ $rentals->links() }}</div>
	</div>
</x-app-layout>
