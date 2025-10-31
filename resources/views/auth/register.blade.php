<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-[#5c4033] text-center">Créer un compte</h2>
        <p class="text-sm text-[#55493f] text-center mt-2">Rejoignez AgriPlatform et accédez à tous nos services</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Nom complet" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Votre nom complet" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" value="Adresse email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="votre@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="profile_role" value="Profil" />
            <select id="profile_role" name="profile_role" class="form-select-agri block mt-1 w-full">
                <option value="">-- Sélectionnez votre profil --</option>
                <option value="buyer" {{ old('profile_role')==='buyer'?'selected':'' }}>Acheteur - Acheter des produits agricoles</option>
                <option value="producer" {{ old('profile_role')==='producer'?'selected':'' }}>Producteur - Vendre vos produits agricoles</option>
                <option value="equipment_owner" {{ old('profile_role')==='equipment_owner'?'selected':'' }}>Propriétaire de matériel - Louer vos équipements agricoles</option>
            </select>
            <x-input-error :messages="$errors->get('profile_role')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Mot de passe" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" 
                            placeholder="Minimum 8 caractères" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <p class="text-xs text-[#55493f] mt-1">Le mot de passe doit contenir au moins 8 caractères</p>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirmer le mot de passe" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" 
                            placeholder="Répétez votre mot de passe" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-[#4CAF50] hover:text-[#81C784]" href="{{ route('login') }}">
                Déjà un compte ? Se connecter
            </a>

            <x-primary-button class="ms-4">
                Créer mon compte
            </x-primary-button>
        </div>

        <div class="mt-4 text-xs text-[#55493f] text-center">
            <p>En créant un compte, vous acceptez nos conditions d'utilisation et notre politique de confidentialité.</p>
        </div>
    </form>
</x-guest-layout>
