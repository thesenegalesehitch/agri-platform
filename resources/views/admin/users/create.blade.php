<x-app-layout>
	<x-slot name="header">
		<h2 class="page-title-agri">Créer un utilisateur</h2>
	</x-slot>

	<div class="content-card fade-in max-w-2xl">
		<form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
			@csrf

			<div class="form-group">
				<label for="name" class="form-label-agri">Nom *</label>
				<input type="text" id="name" name="name" class="form-input-agri" placeholder="Nom" value="{{ old('name') }}" required />
				@error('name')
					<span class="form-error-agri">{{ $message }}</span>
				@enderror
			</div>

			<div class="form-group">
				<label for="email" class="form-label-agri">Email *</label>
				<input type="email" id="email" name="email" class="form-input-agri" placeholder="Email" value="{{ old('email') }}" required />
				@error('email')
					<span class="form-error-agri">{{ $message }}</span>
				@enderror
			</div>

			<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
				<div class="form-group">
					<label for="password" class="form-label-agri">Mot de passe *</label>
					<input type="password" id="password" name="password" class="form-input-agri" placeholder="Mot de passe" required />
					@error('password')
						<span class="form-error-agri">{{ $message }}</span>
					@enderror
				</div>

				<div class="form-group">
					<label for="password_confirmation" class="form-label-agri">Confirmer *</label>
					<input type="password" id="password_confirmation" name="password_confirmation" class="form-input-agri" placeholder="Confirmer" required />
				</div>
			</div>

			<div class="form-group">
				<label for="role" class="form-label-agri">Rôle *</label>
				<select id="role" name="role" class="form-select-agri" required>
					<option value="producer" {{ old('role') == 'producer' ? 'selected' : '' }}>Producteur</option>
					<option value="equipment_owner" {{ old('role') == 'equipment_owner' ? 'selected' : '' }}>Propriétaire matériel</option>
					<option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
				</select>
				@error('role')
					<span class="form-error-agri">{{ $message }}</span>
				@enderror
			</div>

			<div class="flex gap-3 mt-6">
				<button type="submit" class="btn-primary-agri">
					✅ Créer
				</button>
				<a href="{{ route('admin.users.index') }}" class="btn-secondary-agri">
					Annuler
				</a>
			</div>
		</form>
	</div>
</x-app-layout>
