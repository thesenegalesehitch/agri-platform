<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-[#5c4033] text-center">Créer un compte</h2>
        <p class="text-sm text-[#55493f] text-center mt-2">Rejoignez AgriLink et accédez à tous nos services</p>
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
                <option value="producer" {{ old('profile_role')==='producer'?'selected':'' }}>Producteur - Louer des matériels agricoles</option>
                <option value="equipment_owner" {{ old('profile_role')==='equipment_owner'?'selected':'' }}>Propriétaire de matériel - Mettre vos équipements en location</option>
            </select>
            <x-input-error :messages="$errors->get('profile_role')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Mot de passe" />
            <div class="relative">
                <input id="password" class="form-input-agri block mt-1 w-full"
                        type="password"
                        name="password"
                        required autocomplete="new-password"
                        placeholder="Minimum 8 caractères"
                        style="padding-right: 3rem;" />
                <button type="button"
                        onclick="togglePassword('password')"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#55493f] hover:text-[#4CAF50] focus:outline-none"
                        aria-label="Afficher/Masquer le mot de passe">
                    <svg id="password-eye" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg id="password-eye-off" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <p class="text-xs text-[#55493f] mt-1">Le mot de passe doit contenir au moins 8 caractères</p>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirmer le mot de passe" />
            <div class="relative">
                <input id="password_confirmation" class="form-input-agri block mt-1 w-full"
                        type="password"
                        name="password_confirmation" required autocomplete="new-password"
                        placeholder="Répétez votre mot de passe"
                        style="padding-right: 3rem;" />
                <button type="button"
                        onclick="togglePassword('password_confirmation')"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#55493f] hover:text-[#4CAF50] focus:outline-none"
                        aria-label="Afficher/Masquer le mot de passe">
                    <svg id="password_confirmation-eye" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg id="password_confirmation-eye-off" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                    </svg>
                </button>
            </div>
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
