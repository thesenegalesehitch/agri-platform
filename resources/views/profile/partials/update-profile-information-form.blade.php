<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <h3 class="text-md font-medium text-gray-900">Coordonnées</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                <div>
                    <x-input-label for="phone" value="Téléphone" />
                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>
                <div>
                    <x-input-label for="address_line1" value="Adresse" />
                    <x-text-input id="address_line1" name="address_line1" type="text" class="mt-1 block w-full" :value="old('address_line1', $user->address_line1)" />
                    <x-input-error class="mt-2" :messages="$errors->get('address_line1')" />
                </div>
                <div>
                    <x-input-label for="address_line2" value="Complément" />
                    <x-text-input id="address_line2" name="address_line2" type="text" class="mt-1 block w-full" :value="old('address_line2', $user->address_line2)" />
                </div>
                <div>
                    <x-input-label for="city" value="Ville" />
                    <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user->city)" />
                </div>
                <div>
                    <x-input-label for="postal_code" value="Code postal" />
                    <x-text-input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full" :value="old('postal_code', $user->postal_code)" />
                </div>
                <div>
                    <x-input-label for="country" value="Pays" />
                    <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" :value="old('country', $user->country)" />
                </div>
            </div>
        </div>

        @role('buyer')
        <div>
            <h3 class="text-md font-medium text-gray-900">Facturation (Acheteur)</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                <div>
                    <x-input-label for="billing_vat_number" value="N° TVA" />
                    <x-text-input id="billing_vat_number" name="billing_vat_number" type="text" class="mt-1 block w-full" :value="old('billing_vat_number', $user->billing_vat_number)" />
                </div>
            </div>
        </div>
        @endrole

        @role('producer')
        <div>
            <h3 class="text-md font-medium text-gray-900">Exploitant (Producteur)</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                <div>
                    <x-input-label for="farm_name" value="Nom de l'exploitation" />
                    <x-text-input id="farm_name" name="farm_name" type="text" class="mt-1 block w-full" :value="old('farm_name', $user->farm_name)" />
                </div>
                <div>
                    <x-input-label for="farm_type" value="Type d'exploitation" />
                    <x-text-input id="farm_type" name="farm_type" type="text" class="mt-1 block w-full" :value="old('farm_type', $user->farm_type)" />
                </div>
            </div>
        </div>
        @endrole

        @role('equipment_owner')
        <div>
            <h3 class="text-md font-medium text-gray-900">Société (Propriétaire matériel)</h3>
            <div class="grid grid-cols-1 md-grid-cols-2 gap-4 mt-3">
                <div>
                    <x-input-label for="company_name" value="Raison sociale" />
                    <x-text-input id="company_name" name="company_name" type="text" class="mt-1 block w-full" :value="old('company_name', $user->company_name)" />
                </div>
                <div>
                    <x-input-label for="siret" value="SIRET" />
                    <x-text-input id="siret" name="siret" type="text" class="mt-1 block w-full" :value="old('siret', $user->siret)" />
                </div>
                <div>
                    <x-input-label for="fleet_size" value="Taille du parc" />
                    <x-text-input id="fleet_size" name="fleet_size" type="number" class="mt-1 block w-full" :value="old('fleet_size', $user->fleet_size)" />
                </div>
            </div>
        </div>
        @endrole

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
