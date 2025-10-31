<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">Éditer {{ $user->name }}</h2>
	</x-slot>

	<div class="content-card fade-in max-w-2xl">
		<form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
			@csrf @method('PUT')

			<div class="form-group">
				<label for="name" class="form-label-agri">Nom *</label>
				<input type="text" id="name" name="name" class="form-input-agri" value="{{ old('name',$user->name) }}" required />
				@error('name')
					<span class="form-error-agri">{{ $message }}</span>
				@enderror
			</div>

			<div class="form-group">
				<label for="email" class="form-label-agri">Email *</label>
				<input type="email" id="email" name="email" class="form-input-agri" value="{{ old('email',$user->email) }}" required />
				@error('email')
					<span class="form-error-agri">{{ $message }}</span>
				@enderror
			</div>

			<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
				<div class="form-group">
					<label for="password" class="form-label-agri">Nouveau mot de passe</label>
					<input type="password" id="password" name="password" class="form-input-agri" placeholder="Laisser vide pour ne pas changer" />
					@error('password')
						<span class="form-error-agri">{{ $message }}</span>
					@enderror
				</div>

				<div class="form-group">
					<label for="password_confirmation" class="form-label-agri">Confirmer</label>
					<input type="password" id="password_confirmation" name="password_confirmation" class="form-input-agri" placeholder="Si modifié" />
				</div>
			</div>

			<div class="form-group">
				<label for="role" class="form-label-agri">Rôle *</label>
				<select id="role" name="role" class="form-select-agri" required>
					@foreach($roles as $role)
						<option value="{{ $role }}" {{ $user->hasRole($role)?'selected':'' }}>{{ ucfirst($role) }}</option>
					@endforeach
				</select>
				@error('role')
					<span class="form-error-agri">{{ $message }}</span>
				@enderror
			</div>

			<div class="form-group">
				<label class="inline-flex items-center">
					<input 
						type="checkbox" 
						name="is_suspended" 
						value="1" 
						{{ $user->is_suspended ? 'checked' : '' }}
						class="rounded border-[#d0c9c0] text-[#4CAF50] focus:ring-[#4CAF50]"
					/>
					<span class="ml-2 text-[#55493f]">Suspendu</span>
				</label>
			</div>

			<div class="flex gap-3 mt-6">
				<button type="submit" class="btn-primary-agri">
					💾 Enregistrer
				</button>
				<a href="{{ route('admin.users.index') }}" class="btn-secondary-agri">
					Annuler
				</a>
			</div>
		</form>
	</div>
</x-app-layout>
