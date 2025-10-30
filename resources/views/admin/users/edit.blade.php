<x-app-layout>
	<x-slot name="header"><h2 class="font-semibold text-xl">Éditer {{ $user->name }}</h2></x-slot>
	<div class="p-6 max-w-2xl">
		<form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">@csrf @method('PUT')
			<input name="name" class="w-full border p-2" value="{{ old('name',$user->name) }}" required />
			<input type="email" name="email" class="w-full border p-2" value="{{ old('email',$user->email) }}" required />
			<input type="password" name="password" class="w-full border p-2" placeholder="Nouveau mot de passe (optionnel)" />
			<input type="password" name="password_confirmation" class="w-full border p-2" placeholder="Confirmer (si modifié)" />
			<select name="role" class="w-full border p-2" required>
				@foreach($roles as $role)
					<option value="{{ $role }}" {{ $user->hasRole($role)?'selected':'' }}>{{ $role }}</option>
				@endforeach
			</select>
			<label class="inline-flex items-center space-x-2"><input type="checkbox" name="is_suspended" value="1" {{ $user->is_suspended ? 'checked' : '' }} /><span>Suspendu</span></label>
			<div class="flex space-x-2">
				<button class="px-4 py-2 bg-blue-600 text-white rounded">Enregistrer</button>
				<a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-200 rounded">Annuler</a>
			</div>
		</form>
	</div>
</x-app-layout>

