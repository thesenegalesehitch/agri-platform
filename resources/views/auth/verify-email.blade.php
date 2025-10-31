<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-[#5c4033] text-center">Vérification de l'email</h2>
        <p class="text-sm text-[#55493f] text-center mt-2">Veuillez vérifier votre adresse email</p>
    </div>

    <div class="mb-4 text-sm text-[#55493f]">
        Merci de vous être inscrit ! Avant de commencer, veuillez vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer. Si vous n'avez pas reçu l'email, nous pouvons vous en renvoyer un autre.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-lg">
            Un nouveau lien de vérification a été envoyé à l'adresse email que vous avez fournie lors de l'inscription.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    Renvoyer l'email de vérification
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-[#55493f] hover:text-[#4CAF50] rounded-md focus:outline-none">
                Se déconnecter
            </button>
        </form>
    </div>
</x-guest-layout>
