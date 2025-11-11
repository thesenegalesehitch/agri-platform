<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title-agri">Centre d'Aide & Support</h2>
    </x-slot>

    <div class="space-y-6">
        <!-- Hero Section -->
        <div class="content-card fade-in">
            <div class="bg-gradient-to-r from-[#5c4033] to-[#4a3327] p-8 text-white rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">🛠️ Centre d'Aide</h1>
                        <p class="text-white/90 text-lg">Trouvez rapidement des réponses à vos questions</p>
                    </div>
                    <div class="hidden md:block">
                        <img src="/images/pexels-enginakyurt-1435904.jpg" alt="Support technique" class="w-32 h-32 object-cover rounded-lg shadow-lg" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid md:grid-cols-3 gap-6">
            <div class="content-card fade-in text-center hover:shadow-xl transition-shadow">
                <div class="text-4xl mb-4">💬</div>
                <h3 class="section-title-agri">Chat en Ligne</h3>
                <p class="text-[#55493f] mb-4">Discutez avec notre équipe de support en temps réel</p>
                <button class="btn-primary-agri">Démarrer le Chat</button>
            </div>

            <div class="content-card fade-in text-center hover:shadow-xl transition-shadow">
                <div class="text-4xl mb-4">📧</div>
                <h3 class="section-title-agri">Email Support</h3>
                <p class="text-[#55493f] mb-4">Envoyez-nous un email détaillé de votre problème</p>
                <a href="mailto:support@agriplatform.sn" class="btn-primary-agri">Envoyer un Email</a>
            </div>

            <div class="content-card fade-in text-center hover:shadow-xl transition-shadow">
                <div class="text-4xl mb-4">📞</div>
                <h3 class="section-title-agri">Téléphone</h3>
                <p class="text-[#55493f] mb-4">Appelez-nous pour un support immédiat</p>
                <a href="tel:+221771234567" class="btn-primary-agri">+221 77 123 45 67</a>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="content-card fade-in">
            <h2 class="section-title-agri flex items-center">
                <span class="text-3xl mr-3">❓</span>
                Questions Fréquemment Posées
            </h2>

            <div class="space-y-4">
                @php
                    $faqs = [
                        [
                            'q' => 'Comment créer un compte sur AgriLink ?',
                            'a' => 'Pour créer un compte, cliquez sur "Créer un compte" en haut à droite de la page d\'accueil. Choisissez votre rôle (producteur ou propriétaire d\'équipement), complétez vos informations, puis validez votre email.'
                        ],
                        [
                            'q' => 'Comment louer un équipement agricole ?',
                            'a' => 'Connectez-vous en tant que producteur, parcourez les équipements disponibles et cliquez sur "Demander une location". Sélectionnez vos dates et confirmez votre demande.'
                        ],
                        [
                            'q' => 'Comment mettre mon équipement en location ?',
                            'a' => 'Depuis votre compte propriétaire d\'équipement, rendez-vous dans "Mes matériels" puis "Nouveau matériel". Ajoutez une description détaillée, des photos et définissez le tarif journalier.'
                        ],
                        [
                            'q' => 'Comment suivre l\'état de mes demandes ?',
                            'a' => 'Accédez à la rubrique "Mes locations" pour suivre l\'état de vos demandes (en attente, approuvées, rejetées) et consulter les détails de chaque réservation.'
                        ],
                        [
                            'q' => 'Quels sont les frais de commission ?',
                            'a' => 'Une commission de 5% est appliquée sur chaque location finalisée. Elle finance la maintenance et l\'amélioration continue de la plateforme.'
                        ],
                        [
                            'q' => 'Les paiements sont-ils sécurisés ?',
                            'a' => 'Oui, tous les paiements sont traités via des systèmes de paiement certifiés et sécurisés. Nous utilisons le chiffrement SSL et respectons les normes de sécurité les plus élevées.'
                        ],
                    ];
                @endphp

                @foreach($faqs as $faq)
                    <div class="border border-[#d0c9c0] rounded-lg">
                        <button class="w-full text-left p-4 focus:outline-none focus:bg-[#f8f6f3] hover:bg-[#f8f6f3] transition-colors" onclick="toggleFAQ(this)">
                            <div class="flex items-center justify-between">
                                <h3 class="font-medium text-[#5c4033]">{{ $faq['q'] }}</h3>
                                <span class="text-[#55493f] transform transition-transform">▼</span>
                            </div>
                        </button>
                        <div class="px-4 pb-4 hidden">
                            <p class="text-[#55493f]">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Guides et Tutoriels -->
        <div class="content-card fade-in">
            <h2 class="section-title-agri flex items-center">
                <span class="text-3xl mr-3">📚</span>
                Guides et Tutoriels
            </h2>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $guides = [
                        ['icon' => '👤', 'title' => 'Guide du Débutant', 'desc' => 'Apprenez les bases d\'AgriLink en quelques minutes'],
                        ['icon' => '🚜', 'title' => 'Mettre son Matériel en Location', 'desc' => 'Guide complet pour référencer vos équipements agricoles'],
                        ['icon' => '📅', 'title' => 'Préparer une Demande de Location', 'desc' => 'Les bonnes pratiques pour réserver un matériel en toute sérénité'],
                        ['icon' => '💼', 'title' => 'Gérer ses Demandes', 'desc' => 'Suivre et organiser vos demandes de location reçues'],
                        ['icon' => '💳', 'title' => 'Paiements Sécurisés', 'desc' => 'Comprendre notre système de paiement sécurisé'],
                        ['icon' => '📊', 'title' => 'Tableau de Bord', 'desc' => 'Utiliser efficacement votre espace personnel'],
                    ];
                @endphp

                @foreach($guides as $guide)
                    <div class="border border-[#d0c9c0] rounded-lg p-6 hover:shadow-lg transition-shadow">
                        <div class="text-3xl mb-4">{{ $guide['icon'] }}</div>
                        <h3 class="font-semibold text-[#5c4033] mb-2">{{ $guide['title'] }}</h3>
                        <p class="text-[#55493f] mb-4 text-sm">{{ $guide['desc'] }}</p>
                        <a href="#" class="text-[#4CAF50] hover:text-[#81C784] font-medium text-sm">En savoir plus →</a>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Contact Support -->
        <div class="bg-gradient-to-r from-[#5c4033] to-[#4a3327] rounded-lg p-8 text-white text-center fade-in">
            <h2 class="text-2xl font-bold mb-4">Besoin d'aide supplémentaire ?</h2>
            <p class="mb-6 opacity-90">Notre équipe est là pour vous aider. Contactez-nous par le moyen qui vous convient le mieux.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('contact') }}" class="btn-primary-agri" style="background: white; color: #5c4033;">
                    📧 Formulaire de Contact
                </a>
                <a href="tel:+221771234567" class="btn-primary-agri">
                    📞 Appel Téléphonique
                </a>
                <a href="mailto:support@agriplatform.sn" class="btn-secondary-agri" style="background: rgba(255,255,255,0.2); border-color: white; color: white;">
                    ✉️ Email Direct
                </a>
            </div>
        </div>
    </div>

    <script>
        function toggleFAQ(button) {
            const content = button.nextElementSibling;
            const arrow = button.querySelector('.transform');
            content.classList.toggle('hidden');
            if (arrow) arrow.classList.toggle('rotate-180');
        }
    </script>
</x-app-layout>
