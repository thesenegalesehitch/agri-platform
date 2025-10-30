<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Centre d'Aide & Support
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-8">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-8 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold mb-2">🛠️ Centre d'Aide</h1>
                            <p class="text-blue-100 text-lg">Trouvez rapidement des réponses à vos questions</p>
                        </div>
                        <div class="hidden md:block">
                            <img src="/images/pexels-enginakyurt-1435904.jpg" alt="Support technique" class="w-32 h-32 object-cover rounded-lg shadow-lg" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 text-center hover:shadow-2xl transition-shadow">
                    <div class="text-4xl mb-4">💬</div>
                    <h3 class="text-xl font-semibold mb-2">Chat en Ligne</h3>
                    <p class="text-gray-600 mb-4">Discutez avec notre équipe de support en temps réel</p>
                    <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Démarrer le Chat
                    </button>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 text-center hover:shadow-2xl transition-shadow">
                    <div class="text-4xl mb-4">📧</div>
                    <h3 class="text-xl font-semibold mb-2">Email Support</h3>
                    <p class="text-gray-600 mb-4">Envoyez-nous un email détaillé de votre problème</p>
                    <a href="mailto:support@agriplatform.sn" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors inline-block">
                        Envoyer un Email
                    </a>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 text-center hover:shadow-2xl transition-shadow">
                    <div class="text-4xl mb-4">📞</div>
                    <h3 class="text-xl font-semibold mb-2">Téléphone</h3>
                    <p class="text-gray-600 mb-4">Appelez-nous pour un support immédiat</p>
                    <a href="tel:+221771234567" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition-colors inline-block">
                        +221 77 123 45 67
                    </a>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-8">
                <div class="p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="text-3xl mr-3">❓</span>
                        Questions Fréquemment Posées
                    </h2>

                    <div class="space-y-4">
                        <div class="border border-gray-200 rounded-lg">
                            <button class="w-full text-left p-4 focus:outline-none focus:bg-gray-50 hover:bg-gray-50 transition-colors" onclick="toggleFAQ(this)">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-gray-800">Comment créer un compte sur Agri-Platform ?</h3>
                                    <span class="text-gray-400 transform transition-transform">▼</span>
                                </div>
                            </button>
                            <div class="px-4 pb-4 hidden">
                                <p class="text-gray-600">Pour créer un compte, cliquez sur "Créer un compte" en haut à droite de la page d'accueil. Remplissez le formulaire avec vos informations personnelles, votre rôle (producteur, acheteur, ou propriétaire d'équipement), et validez votre email.</p>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-lg">
                            <button class="w-full text-left p-4 focus:outline-none focus:bg-gray-50 hover:bg-gray-50 transition-colors" onclick="toggleFAQ(this)">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-gray-800">Comment ajouter un produit à vendre ?</h3>
                                    <span class="text-gray-400 transform transition-transform">▼</span>
                                </div>
                            </button>
                            <div class="px-4 pb-4 hidden">
                                <p class="text-gray-600">Connectez-vous à votre compte producteur, allez dans "Mes Produits", cliquez sur "Nouveau". Remplissez les informations de votre produit (nom, description, prix, catégorie) et ajoutez des photos de qualité.</p>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-lg">
                            <button class="w-full text-left p-4 focus:outline-none focus:bg-gray-50 hover:bg-gray-50 transition-colors" onclick="toggleFAQ(this)">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-gray-800">Comment louer un équipement agricole ?</h3>
                                    <span class="text-gray-400 transform transition-transform">▼</span>
                                </div>
                            </button>
                            <div class="px-4 pb-4 hidden">
                                <p class="text-gray-600">Parcourez les équipements disponibles, sélectionnez celui qui vous intéresse, et cliquez sur "Demander une location". Choisissez vos dates de location et soumettez votre demande.</p>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-lg">
                            <button class="w-full text-left p-4 focus:outline-none focus:bg-gray-50 hover:bg-gray-50 transition-colors" onclick="toggleFAQ(this)">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-gray-800">Quels sont les frais de commission ?</h3>
                                    <span class="text-gray-400 transform transition-transform">▼</span>
                                </div>
                            </button>
                            <div class="px-4 pb-4 hidden">
                                <p class="text-gray-600">Nous appliquons une commission de 5% sur chaque transaction réussie. Cette commission nous permet de maintenir et améliorer la plateforme pour tous les utilisateurs.</p>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-lg">
                            <button class="w-full text-left p-4 focus:outline-none focus:bg-gray-50 hover:bg-gray-50 transition-colors" onclick="toggleFAQ(this)">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-gray-800">Comment modifier mes informations personnelles ?</h3>
                                    <span class="text-gray-400 transform transition-transform">▼</span>
                                </div>
                            </button>
                            <div class="px-4 pb-4 hidden">
                                <p class="text-gray-600">Allez dans votre profil en cliquant sur votre nom en haut à droite, puis sélectionnez "Profil". Vous pourrez modifier vos informations personnelles, votre mot de passe, et vos préférences.</p>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-lg">
                            <button class="w-full text-left p-4 focus:outline-none focus:bg-gray-50 hover:bg-gray-50 transition-colors" onclick="toggleFAQ(this)">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-gray-800">Les paiements sont-ils sécurisés ?</h3>
                                    <span class="text-gray-400 transform transition-transform">▼</span>
                                </div>
                            </button>
                            <div class="px-4 pb-4 hidden">
                                <p class="text-gray-600">Oui, tous les paiements sont traités via des systèmes de paiement sécurisés certifiés. Nous utilisons le chiffrement SSL et respectons les normes de sécurité les plus élevées.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guides et Tutoriels -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-8">
                <div class="p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="text-3xl mr-3">📚</span>
                        Guides et Tutoriels
                    </h2>

                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <div class="text-3xl mb-4">👤</div>
                            <h3 class="text-lg font-semibold mb-2">Guide du Débutant</h3>
                            <p class="text-gray-600 mb-4">Apprenez les bases d'Agri-Platform en 5 minutes</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Lire le guide →</a>
                        </div>

                        <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <div class="text-3xl mb-4">📦</div>
                            <h3 class="text-lg font-semibold mb-2">Vendre ses Produits</h3>
                            <p class="text-gray-600 mb-4">Comment créer et gérer vos annonces de produits</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Voir le tutoriel →</a>
                        </div>

                        <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <div class="text-3xl mb-4">🚜</div>
                            <h3 class="text-lg font-semibold mb-2">Louer son Équipement</h3>
                            <p class="text-gray-600 mb-4">Guide complet pour louer vos équipements agricoles</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Découvrir →</a>
                        </div>

                        <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <div class="text-3xl mb-4">🛒</div>
                            <h3 class="text-lg font-semibold mb-2">Acheter en Ligne</h3>
                            <p class="text-gray-600 mb-4">Comment passer commande et suivre vos achats</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Apprendre →</a>
                        </div>

                        <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg p-6 hover:shadow-lg transition-shadow">
                            <div class="text-3xl mb-4">💳</div>
                            <h3 class="text-lg font-semibold mb-2">Paiements Sécurisés</h3>
                            <p class="text-gray-600 mb-4">Comprendre notre système de paiement sécurisé</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">En savoir plus →</a>
                        </div>

                        <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <div class="text-3xl mb-4">📊</div>
                            <h3 class="text-lg font-semibold mb-2">Tableau de Bord</h3>
                            <p class="text-gray-600 mb-4">Utiliser efficacement votre espace personnel</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Explorer →</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg p-8 text-white text-center">
                <h2 class="text-2xl font-bold mb-4">Besoin d'aide supplémentaire ?</h2>
                <p class="mb-6 opacity-90">Notre équipe est là pour vous aider. Contactez-nous par le moyen qui vous convient le mieux.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('contact') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg hover:bg-gray-100 transition-colors font-medium">
                        📧 Formulaire de Contact
                    </a>
                    <a href="tel:+221771234567" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-400 transition-colors font-medium">
                        📞 Appel Téléphonique
                    </a>
                    <a href="mailto:support@agriplatform.sn" class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-400 transition-colors font-medium">
                        ✉️ Email Direct
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleFAQ(button) {
            const content = button.nextElementSibling;
            const arrow = button.querySelector('.transform');

            content.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }
    </script>
</x-app-layout>