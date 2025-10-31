<x-guest-layout>
    <div class="mb-6">
        <h2 class="page-title-agri text-center">Récupération de compte</h2>
        <p class="text-center text-[#55493f]" style="margin-top: 0.5rem;">Récupérez l'accès à votre compte</p>
    </div>

    <div class="mb-4 text-sm text-[#55493f]">
        {{ __('Vous avez oublié votre mot de passe ? Aucun problème. Indiquez-nous votre adresse email et nous vous enverrons un lien de réinitialisation qui vous permettra d\'en choisir un nouveau.') }}
    </div>

    <!-- Session Status -->
    @if(session('status'))
        <div class="alert-agri alert-success-agri mb-4">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Envoyer le lien de réinitialisation') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-4 text-center">
        <p class="text-sm text-[#55493f]">
            Vous vous souvenez de votre mot de passe ? 
            <a href="{{ route('login') }}" class="text-[#4CAF50] hover:underline font-medium">
                Se connecter
            </a>
        </p>
    </div>
</x-guest-layout>
