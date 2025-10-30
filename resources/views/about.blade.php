<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            À propos d'Agri-Platform
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-8">
                <div class="bg-gradient-to-r from-green-600 to-green-800 p-8 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold mb-2">🌾 Notre Mission</h1>
                            <p class="text-green-100 text-lg">Transformer l'agriculture sénégalaise à travers la technologie et l'innovation</p>
                        </div>
                        <div class="hidden md:block">
                            <img src="/images/pexels-enginakyurt-1435904.jpg" alt="Agriculture moderne" class="w-32 h-32 object-cover rounded-lg shadow-lg" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notre Histoire -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-8">
                <div class="p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="text-3xl mr-3">📖</span>
                        Notre Histoire
                    </h2>
                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <p class="text-gray-600 mb-4 leading-relaxed">
                                Agri-Platform Sénégal est née en 2023 d'une vision simple : connecter les agriculteurs modernes du Sénégal avec les technologies qui peuvent transformer leur quotidien. Fondée par une équipe d'experts passionnés par l'agriculture durable, notre plateforme est le fruit de plusieurs années d'expérience sur le terrain.
                            </p>
                            <p class="text-gray-600 mb-4 leading-relaxed">
                                Nous avons constaté que malgré les avancées technologiques mondiales, de nombreux agriculteurs sénégalais peinaient à accéder aux outils modernes qui pourraient révolutionner leur productivité. C'est cette lacune que nous avons décidé de combler.
                            </p>
                        </div>
                        <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-lg">
                            <h3 class="font-semibold text-green-800 mb-3">Chiffres Clés</h3>
                            <ul class="space-y-2 text-sm text-gray-700">
                                <li class="flex items-center">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                                    <strong>500+</strong> agriculteurs actifs
                                </li>
                                <li class="flex items-center">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                                    <strong>1000+</strong> produits commercialisés
                                </li>
                                <li class="flex items-center">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                                    <strong>98%</strong> taux de satisfaction
                                </li>
                                <li class="flex items-center">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                                    <strong>12</strong> régions couvertes
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nos Valeurs -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-8">
                <div class="p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="text-3xl mr-3">💚</span>
                        Nos Valeurs
                    </h2>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="text-center p-6 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <div class="text-4xl mb-4">🌱</div>
                            <h3 class="font-semibold text-green-800 mb-2">Innovation</h3>
                            <p class="text-gray-600 text-sm">Nous intégrons constamment les dernières technologies pour améliorer l'agriculture sénégalaise.</p>
                        </div>
                        <div class="text-center p-6 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <div class="text-4xl mb-4">🤝</div>
                            <h3 class="font-semibold text-blue-800 mb-2">Transparence</h3>
                            <p class="text-gray-600 text-sm">Toutes nos transactions sont sécurisées et transparentes pour garantir la confiance.</p>
                        </div>
                        <div class="text-center p-6 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                            <div class="text-4xl mb-4">♻️</div>
                            <h3 class="font-semibold text-orange-800 mb-2">Durabilité</h3>
                            <p class="text-gray-600 text-sm">Nous promouvons des pratiques agricoles respectueuses de l'environnement.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notre Équipe -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-8">
                <div class="p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="text-3xl mr-3">👥</span>
                        Notre Équipe
                    </h2>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="w-24 h-24 bg-gradient-to-br from-green-400 to-green-600 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-2xl font-bold">
                                AD
                            </div>
                            <h3 class="font-semibold text-gray-800">Amadou Diallo</h3>
                            <p class="text-green-600 text-sm mb-2">Directeur Général</p>
                            <p class="text-gray-600 text-sm">Expert en agriculture digitale avec 15 ans d'expérience</p>
                        </div>
                        <div class="text-center">
                            <div class="w-24 h-24 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-2xl font-bold">
                                FS
                            </div>
                            <h3 class="font-semibold text-gray-800">Fatou Sow</h3>
                            <p class="text-blue-600 text-sm mb-2">Directrice Technique</p>
                            <p class="text-gray-600 text-sm">Spécialiste en développement durable et innovation agricole</p>
                        </div>
                        <div class="text-center">
                            <div class="w-24 h-24 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-2xl font-bold">
                                MK
                            </div>
                            <h3 class="font-semibold text-gray-800">Mamadou Kane</h3>
                            <p class="text-purple-600 text-sm mb-2">Responsable Commercial</p>
                            <p class="text-gray-600 text-sm">Expert en développement de partenariats stratégiques</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notre Impact -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="text-3xl mr-3">📊</span>
                        Notre Impact
                    </h2>
                    <div class="bg-gradient-to-r from-green-50 to-blue-50 p-6 rounded-lg">
                        <p class="text-gray-700 mb-4 leading-relaxed">
                            Depuis notre lancement, Agri-Platform Sénégal a contribué à transformer l'écosystème agricole sénégalais en :
                        </p>
                        <ul class="space-y-3 text-gray-700">
                            <li class="flex items-start">
                                <span class="text-green-500 mr-3 mt-1">✓</span>
                                <span><strong>Augmentation des revenus</strong> : Nos agriculteurs partenaires ont vu leurs revenus augmenter de 35% en moyenne grâce à l'accès à de nouveaux marchés.</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mr-3 mt-1">✓</span>
                                <span><strong>Réduction du gaspillage</strong> : Notre plateforme a permis de réduire le gaspillage alimentaire de 40% en connectant directement producteurs et consommateurs.</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mr-3 mt-1">✓</span>
                                <span><strong>Adoption de technologies</strong> : Plus de 200 équipements modernes ont été mis à disposition via notre service de location.</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-500 mr-3 mt-1">✓</span>
                                <span><strong>Création d'emplois</strong> : Notre plateforme a contribué à créer plus de 150 emplois directs et indirects dans les zones rurales.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>