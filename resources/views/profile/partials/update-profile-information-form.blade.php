<section>
    <header>
        <h2 class="section-title-agri">
            {{ __('Informations du Profil') }}
        </h2>
        <p class="mt-1 text-sm text-[#55493f]">
            {{ __('Mettez à jour les informations de votre profil et votre adresse email.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Informations de base -->
        <div class="form-group">
            <x-input-label for="name" :value="__('Nom complet')" />
            <x-text-input id="name" name="name" type="text" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div class="form-group">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-[#55493f]">
                        {{ __('Votre adresse email n\'est pas vérifiée.') }}
                        <button form="send-verification" class="underline text-sm text-[#4CAF50] hover:text-[#81C784]">
                            {{ __('Cliquez ici pour renvoyer l\'email de vérification.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-[#4CAF50]">
                            {{ __('Un nouveau lien de vérification a été envoyé à votre adresse email.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Téléphone avec vérification -->
        <div class="form-group">
            <x-input-label for="phone" :value="__('Numéro de téléphone')" />
            <div class="flex gap-2">
                <x-text-input 
                    id="phone" 
                    name="phone" 
                    type="text" 
                    :value="old('phone', $user->phone)" 
                    placeholder="+221XXXXXXXXX ou 00221XXXXXXXXX"
                    class="flex-1"
                />
                @if($user->phone_verified)
                    <span class="px-3 py-2 bg-green-100 text-green-800 rounded-lg text-sm font-medium flex items-center">
                        ✓ Vérifié
                    </span>
                @elseif($user->phone)
                    <form method="POST" action="{{ route('profile.verify-phone') }}" class="inline">
                        @csrf
                        <button type="button" onclick="sendVerificationCode()" class="btn-secondary-agri">
                            Envoyer code
                        </button>
                    </form>
                @else
                    <button type="button" onclick="sendVerificationCode()" class="btn-secondary-agri">
                        Vérifier
                    </button>
                @endif
            </div>
            <x-input-error :messages="$errors->get('phone')" />
            
            @if($user->phone && !$user->phone_verified && session('phone_code'))
                <div class="mt-3 p-3 bg-blue-50 rounded-lg">
                    <p class="text-sm text-[#55493f] mb-2">Code de vérification envoyé. Entrez le code reçu :</p>
                    <form method="POST" action="{{ route('profile.verify-phone') }}" class="flex gap-2">
                        @csrf
                        <input 
                            type="text" 
                            name="verification_code" 
                            maxlength="6" 
                            class="form-input-agri w-32 text-center text-lg tracking-widest"
                            placeholder="000000"
                            required
                        >
                        <button type="submit" class="btn-primary-agri">
                            Vérifier
                        </button>
                    </form>
                    <p class="text-xs text-[#55493f] mt-2">Code de test (pour développement) : {{ session('phone_code') }}</p>
                </div>
            @endif
        </div>

        <!-- CNI -->
        <div class="border-t border-[#d0c9c0] pt-6 mt-6">
            <h3 class="section-title-agri mb-4">📄 Vérification d'identité (CNI)</h3>
            <p class="text-sm text-[#55493f] mb-4">
                Pour votre sécurité et celle de notre communauté, nous vérifions l'identité de tous nos utilisateurs.
            </p>

            <div class="form-group">
                <x-input-label for="cni_number" value="Numéro de CNI" />
                <x-text-input id="cni_number" name="cni_number" type="text" :value="old('cni_number', $user->cni_number)" placeholder="Ex: 1234567890123456" />
                <x-input-error :messages="$errors->get('cni_number')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                    <x-input-label for="cni_recto" value="Photo recto de la CNI *" />
                    <input 
                        type="file" 
                        id="cni_recto" 
                        name="cni_recto" 
                        accept="image/*" 
                        class="form-input-agri"
                        onchange="previewImage(this, 'cni-recto-preview')"
                    />
                    <x-input-error :messages="$errors->get('cni_recto')" />
                    @if($user->cni_recto_path)
                        <div class="mt-2">
                            <img src="{{ Storage::url($user->cni_recto_path) }}" alt="CNI Recto" class="w-32 h-20 object-cover rounded border border-[#d0c9c0]">
                            <p class="text-xs text-[#55493f] mt-1">Photo actuelle</p>
                        </div>
                    @endif
                    <div id="cni-recto-preview" class="mt-2 hidden">
                        <img src="" alt="Aperçu" class="w-32 h-20 object-cover rounded border border-[#d0c9c0]">
                    </div>
                </div>

                <div class="form-group">
                    <x-input-label for="cni_verso" value="Photo verso de la CNI *" />
                    <input 
                        type="file" 
                        id="cni_verso" 
                        name="cni_verso" 
                        accept="image/*" 
                        class="form-input-agri"
                        onchange="previewImage(this, 'cni-verso-preview')"
                    />
                    <x-input-error :messages="$errors->get('cni_verso')" />
                    @if($user->cni_verso_path)
                        <div class="mt-2">
                            <img src="{{ Storage::url($user->cni_verso_path) }}" alt="CNI Verso" class="w-32 h-20 object-cover rounded border border-[#d0c9c0]">
                            <p class="text-xs text-[#55493f] mt-1">Photo actuelle</p>
                        </div>
                    @endif
                    <div id="cni-verso-preview" class="mt-2 hidden">
                        <img src="" alt="Aperçu" class="w-32 h-20 object-cover rounded border border-[#d0c9c0]">
                    </div>
                </div>
            </div>

            @if($user->cni_verified)
                <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-sm text-green-800 font-medium flex items-center gap-2">
                        <span>✓</span> Votre CNI a été vérifiée le {{ $user->cni_verified_at->format('d/m/Y à H:i') }}
                    </p>
                </div>
            @elseif($user->cni_recto_path && $user->cni_verso_path)
                <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-sm text-yellow-800">
                        ⏳ Votre CNI est en cours de vérification. Vous serez notifié une fois la vérification terminée.
                    </p>
                </div>
            @endif
        </div>

        <!-- Adresse avec Région/Ville Sénégal -->
        <div class="border-t border-[#d0c9c0] pt-6 mt-6">
            <h3 class="section-title-agri mb-4">📍 Adresse</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                    <x-input-label for="region" value="Région *" />
                    <select id="region" name="region" class="form-select-agri" onchange="updateVilles()">
                        <option value="">Sélectionnez une région</option>
                        @php
                            $regions = [
                                'Dakar' => ['Pikine', 'Guédiawaye', 'Rufisque', 'Diamniadio', 'Bargny', 'Sébikhotane'],
                                'Diourbel' => ['Touba', 'Mbacké', 'Bambey', 'Baba Garage', 'Dinguiraye'],
                                'Fatick' => ['Foundiougne', 'Gossas', 'Guinguinéo', 'Sokone'],
                                'Kaffrine' => ['Koungheul', 'Malem Hodar', 'Birkelane'],
                                'Kaolack' => ['Nioro du Rip', 'Kounoune', 'Gandiaye', 'Kahone'],
                                'Kédougou' => ['Saraya', 'Salémata'],
                                'Kolda' => ['Vélingara', 'Médina Yoro Foulah'],
                                'Louga' => ['Linguère', 'Kébémer', 'Dahra'],
                                'Matam' => ['Ourossogui', 'Thilogne', 'Kanel', 'Waoundé'],
                                'Saint-Louis' => ['Richard-Toll', 'Podor', 'Dagana', 'Ndioum'],
                                'Sédhiou' => ['Goudomp', 'Bounkiling', 'Marsassoum'],
                                'Tambacounda' => ['Bakel', 'Kidira', 'Goudiry', 'Diawara'],
                                'Thiès' => ['Mbour', 'Tivaouane', 'Joal-Fadiouth', 'Pout', 'Khombole', 'Mboro'],
                                'Ziguinchor' => ['Bignona', 'Oussouye', 'Thionck Essyl'],
                            ];
                        @endphp
                        @foreach($regions as $regName => $villes)
                            <option value="{{ $regName }}" {{ old('region', $user->region) === $regName ? 'selected' : '' }}>{{ $regName }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('region')" />
                </div>

                <div class="form-group">
                    <x-input-label for="ville" value="Ville *" />
                    <select id="ville" name="ville" class="form-select-agri">
                        <option value="">Sélectionnez d'abord une région</option>
                    </select>
                    <x-input-error :messages="$errors->get('ville')" />
                </div>
            </div>

            <div class="form-group mt-4">
                <x-input-label for="address_line1" value="Adresse complète" />
                <x-text-input id="address_line1" name="address_line1" type="text" :value="old('address_line1', $user->address_line1)" placeholder="Rue, numéro, quartier..." />
                <x-input-error :messages="$errors->get('address_line1')" />
            </div>

            <div class="form-group">
                <x-input-label for="address_line2" value="Complément d'adresse" />
                <x-text-input id="address_line2" name="address_line2" type="text" :value="old('address_line2', $user->address_line2)" placeholder="Appartement, étage, etc." />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                    <x-input-label for="postal_code" value="Code postal" />
                    <x-text-input id="postal_code" name="postal_code" type="text" :value="old('postal_code', $user->postal_code)" />
                </div>
                <div class="form-group">
                    <x-input-label for="country" value="Pays" />
                    <x-text-input id="country" name="country" type="text" value="Sénégal" readonly class="form-input-agri bg-gray-100" />
                </div>
            </div>
        </div>

        <!-- Champs spécifiques selon le rôle -->
        @role('producer')
        <div class="border-t border-[#d0c9c0] pt-6 mt-6">
            <h3 class="section-title-agri mb-4">🌾 Exploitant (Producteur)</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                    <x-input-label for="farm_name" value="Nom de l'exploitation" />
                    <x-text-input id="farm_name" name="farm_name" type="text" :value="old('farm_name', $user->farm_name)" />
                </div>
                <div class="form-group">
                    <x-input-label for="farm_type" value="Type d'exploitation" />
                    <x-text-input id="farm_type" name="farm_type" type="text" :value="old('farm_type', $user->farm_type)" placeholder="Ex: Maraîchage, Céréales..." />
                </div>
            </div>
        </div>
        @endrole

        @role('equipment_owner')
        <div class="border-t border-[#d0c9c0] pt-6 mt-6">
            <h3 class="section-title-agri mb-4">🚜 Société (Propriétaire matériel)</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                    <x-input-label for="company_name" value="Raison sociale" />
                    <x-text-input id="company_name" name="company_name" type="text" :value="old('company_name', $user->company_name)" />
                </div>
                <div class="form-group">
                    <x-input-label for="siret" value="SIRET/NINEA" />
                    <x-text-input id="siret" name="siret" type="text" :value="old('siret', $user->siret)" />
                </div>
                <div class="form-group">
                    <x-input-label for="fleet_size" value="Taille du parc d'équipements" />
                    <x-text-input id="fleet_size" name="fleet_size" type="number" :value="old('fleet_size', $user->fleet_size)" min="0" />
                </div>
            </div>
        </div>
        @endrole

        <!-- Section Récupération de compte -->
        <div class="border-t border-[#d0c9c0] pt-6 mt-6">
            <h3 class="section-title-agri mb-4">🔐 Sécurité et Récupération</h3>
            <div class="bg-[#f8f6f3] p-4 rounded-lg space-y-3">
                <p class="text-sm text-[#55493f]">
                    <strong class="text-[#5c4033]">Récupération de compte :</strong> En cas de perte d'accès à votre compte, vous pouvez réinitialiser votre mot de passe par email.
                </p>
                <a href="{{ route('password.request') }}" class="text-sm text-[#4CAF50] hover:text-[#81C784] underline">
                    Réinitialiser mon mot de passe →
                </a>
            </div>
        </div>

        <!-- Demande de réactivation si suspendu -->
        @if($user->is_suspended)
            <div class="border-t border-red-300 pt-6 mt-6">
                <div class="bg-red-50 border-2 border-red-200 rounded-lg p-4">
                    <h3 class="section-title-agri mb-4 text-red-800">⚠️ Compte Suspendu</h3>
                    <p class="text-sm text-red-700 mb-4">
                        Votre compte a été suspendu. Vous ne pouvez pas accéder aux fonctionnalités de la plateforme tant que votre compte n'est pas réactivé.
                    </p>
                    
                    @php
                        $pendingRequest = \App\Models\SuspensionRequest::where('user_id', $user->id)
                            ->where('status', 'pending')
                            ->exists();
                    @endphp
                    
                    @if(!$pendingRequest)
                        <form method="POST" action="{{ route('suspension-requests.store') }}" class="space-y-3">
                            @csrf
                            <div class="form-group">
                                <label class="form-label-agri">Raison de la demande de réactivation *</label>
                                <textarea 
                                    name="reason" 
                                    class="form-textarea-agri" 
                                    rows="4" 
                                    placeholder="Expliquez pourquoi votre compte devrait être réactivé..." 
                                    required
                                ></textarea>
                                <p class="text-xs text-[#55493f] mt-1">Votre demande sera examinée par un administrateur.</p>
                            </div>
                            <button type="submit" class="btn-primary-agri">
                                📤 Envoyer la demande de réactivation
                            </button>
                        </form>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                            <p class="text-sm text-yellow-800">
                                ⏳ Votre demande de réactivation est en cours d'examen. Vous serez notifié de la décision par email.
                            </p>
                            <a href="{{ route('suspension-requests.index') }}" class="text-sm text-[#4CAF50] hover:underline mt-2 inline-block">
                                Voir mes demandes →
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <!-- Protection contre les arnaques -->
            <div class="border-t border-[#d0c9c0] pt-6 mt-6">
                <h3 class="section-title-agri mb-4">🛡️ Protection contre les arnaques</h3>
                <div class="bg-[#f8f6f3] p-4 rounded-lg">
                    <ul class="text-xs text-[#55493f] space-y-2 list-disc list-inside">
                        <li>Votre CNI est vérifiée par notre équipe pour garantir votre identité</li>
                        <li>Votre numéro de téléphone vérifié permet de vous contacter en cas de problème</li>
                        <li>Ne partagez jamais vos identifiants avec des tiers</li>
                        <li>Signalez immédiatement toute activité suspecte via le support</li>
                        <li>Vérifiez toujours l'identité de vos interlocuteurs avant toute transaction</li>
                    </ul>
                </div>
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-[#4CAF50] font-medium"
                >{{ __('Enregistré.') }}</p>
            @endif
            
            @if (session('status') === 'phone-code-sent')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 5000)"
                    class="text-sm text-[#4CAF50] font-medium"
                >Code de vérification envoyé ! Vérifiez votre téléphone.</p>
            @endif
            
            @if (session('status') === 'phone-verified')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-[#4CAF50] font-medium"
                >Téléphone vérifié avec succès !</p>
            @endif
        </div>
    </form>

    <script>
        // Données des régions/villes du Sénégal
        @php
            $regionsArray = [
                ['Dakar', ['Pikine', 'Guédiawaye', 'Rufisque', 'Diamniadio', 'Bargny', 'Sébikhotane']],
                ['Diourbel', ['Touba', 'Mbacké', 'Bambey', 'Baba Garage', 'Dinguiraye']],
                ['Fatick', ['Foundiougne', 'Gossas', 'Guinguinéo', 'Sokone']],
                ['Kaffrine', ['Koungheul', 'Malem Hodar', 'Birkelane']],
                ['Kaolack', ['Nioro du Rip', 'Kounoune', 'Gandiaye', 'Kahone']],
                ['Kédougou', ['Saraya', 'Salémata']],
                ['Kolda', ['Vélingara', 'Médina Yoro Foulah']],
                ['Louga', ['Linguère', 'Kébémer', 'Dahra']],
                ['Matam', ['Ourossogui', 'Thilogne', 'Kanel', 'Waoundé']],
                ['Saint-Louis', ['Richard-Toll', 'Podor', 'Dagana', 'Ndioum']],
                ['Sédhiou', ['Goudomp', 'Bounkiling', 'Marsassoum']],
                ['Tambacounda', ['Bakel', 'Kidira', 'Goudiry', 'Diawara']],
                ['Thiès', ['Mbour', 'Tivaouane', 'Joal-Fadiouth', 'Pout', 'Khombole', 'Mboro']],
                ['Ziguinchor', ['Bignona', 'Oussouye', 'Thionck Essyl']],
            ];
            $regionsData = [];
            foreach ($regionsArray as [$region, $villes]) {
                $regionsData[$region] = $villes;
            }
        @endphp
        const regionsData = @json($regionsData);

        function updateVilles() {
            const region = document.getElementById('region').value;
            const villeSelect = document.getElementById('ville');
            const currentVille = @json(old('ville', $user->ville));

            villeSelect.innerHTML = '<option value="">Sélectionnez une ville</option>';
            
            if (region && regionsData[region]) {
                regionsData[region].forEach(ville => {
                    const option = document.createElement('option');
                    option.value = ville;
                    option.textContent = ville;
                    if (currentVille === ville) {
                        option.selected = true;
                    }
                    villeSelect.appendChild(option);
                });
            }
        }

        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.querySelector('img').src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function sendVerificationCode() {
            const phone = document.getElementById('phone').value;
            if (!phone) {
                alert('Veuillez d\'abord entrer votre numéro de téléphone');
                return;
            }
            
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("profile.send-phone-code") }}';
            
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);
            
            const phoneInput = document.createElement('input');
            phoneInput.type = 'hidden';
            phoneInput.name = 'phone';
            phoneInput.value = phone;
            form.appendChild(phoneInput);
            
            document.body.appendChild(form);
            form.submit();
        }

        // Initialiser les villes si une région est déjà sélectionnée
        document.addEventListener('DOMContentLoaded', function() {
            const currentRegion = @json(old('region', $user->region));
            if (currentRegion) {
                updateVilles();
            }
        });
    </script>
</section>
