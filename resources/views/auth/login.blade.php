<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-[#5c4033] text-center">Connexion</h2>
        <p class="text-sm text-[#55493f] text-center mt-2">Connectez-vous à votre compte AgriPlatform</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Adresse email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="votre@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Mot de passe" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" 
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#4CAF50] shadow-sm focus:ring-[#4CAF50]" name="remember">
                <span class="ms-2 text-sm text-[#55493f]">Se souvenir de moi</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-[#4CAF50] hover:text-[#81C784] rounded-md focus:outline-none" href="{{ route('password.request') }}">
                    Mot de passe oublié ?
                </a>
            @endif

            <x-primary-button class="ms-3">
                Se connecter
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-[#55493f]">
            Pas encore de compte ? 
            <a href="{{ route('register') }}" class="text-[#4CAF50] hover:text-[#81C784] font-semibold underline">
                Créer un compte
            </a>
        </p>
    </div>
</x-guest-layout>
