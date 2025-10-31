<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-[#5c4033] text-center">Réinitialiser le mot de passe</h2>
        <p class="text-sm text-[#55493f] text-center mt-2">Choisissez un nouveau mot de passe pour votre compte</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Adresse email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" placeholder="votre@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Nouveau mot de passe" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="Minimum 8 caractères" />
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
            <x-primary-button>
                Réinitialiser le mot de passe
            </x-primary-button>
        </div>
    </form>

    <div class="mt-4 text-center">
        <p class="text-sm text-[#55493f]">
            Vous vous souvenez de votre mot de passe ? 
            <a href="{{ route('login') }}" class="text-[#4CAF50] hover:text-[#81C784] font-semibold underline">
                Se connecter
            </a>
        </p>
    </div>
</x-guest-layout>
