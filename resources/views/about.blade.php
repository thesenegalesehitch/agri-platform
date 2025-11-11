<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title-agri">À propos d'AgriLink</h2>
    </x-slot>

    <div class="space-y-6">
        <!-- Hero Section -->
        <div class="content-card fade-in">
            <div class="bg-gradient-to-r from-[#5c4033] to-[#4a3327] p-8 text-white rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">🌾 Notre Mission</h1>
                        <p class="text-white/90 text-lg">Transformer l'agriculture sénégalaise à travers la technologie et l'innovation</p>
                    </div>
                    <div class="hidden md:block">
                        <img src="/images/pexels-enginakyurt-1435904.jpg" alt="Agriculture moderne" class="w-32 h-32 object-cover rounded-lg shadow-lg" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Notre Histoire -->
        <div class="content-card fade-in">
            <h2 class="section-title-agri flex items-center">
                <span class="text-3xl mr-3">📖</span>
                Notre Histoire
            </h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <p class="text-[#55493f] mb-4 leading-relaxed">
                        AgriLink Sénégal est née en 2023 d'une vision simple : connecter les agriculteurs modernes du Sénégal avec les technologies qui peuvent transformer leur quotidien. Fondée par une équipe d'experts passionnés par l'agriculture durable, notre plateforme est le fruit de plusieurs années d'expérience sur le terrain.
                    </p>
                    <p class="text-[#55493f] mb-4 leading-relaxed">
                        Nous avons constaté que malgré les avancées technologiques mondiales, de nombreux agriculteurs sénégalais peinaient à accéder aux outils modernes qui pourraient révolutionner leur productivité. C'est cette lacune que nous avons décidé de combler.
                    </p>
                </div>
                <div class="bg-[#f8f6f3] p-6 rounded-lg">
                    <h3 class="font-semibold text-[#5c4033] mb-3">Chiffres Clés</h3>
                    <ul class="space-y-2 text-sm text-[#55493f]">
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-[#4CAF50] rounded-full mr-3"></span>
                            <strong>500+</strong> agriculteurs actifs
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-[#4CAF50] rounded-full mr-3"></span>
                            <strong>1000+</strong> locations réalisées
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-[#4CAF50] rounded-full mr-3"></span>
                            <strong>98%</strong> taux de satisfaction
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-[#4CAF50] rounded-full mr-3"></span>
                            <strong>12</strong> régions couvertes
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Nos Valeurs -->
        <div class="content-card fade-in">
            <h2 class="section-title-agri flex items-center">
                <span class="text-3xl mr-3">💚</span>
                Nos Valeurs
            </h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="text-center p-6 bg-[#f8f6f3] rounded-lg hover:bg-green-50 transition-colors">
                    <div class="text-4xl mb-4">🌱</div>
                    <h3 class="font-semibold text-[#5c4033] mb-2">Innovation</h3>
                    <p class="text-[#55493f] text-sm">Nous intégrons constamment les dernières technologies pour améliorer l'agriculture sénégalaise.</p>
                </div>
                <div class="text-center p-6 bg-[#f8f6f3] rounded-lg hover:bg-blue-50 transition-colors">
                    <div class="text-4xl mb-4">🤝</div>
                    <h3 class="font-semibold text-[#5c4033] mb-2">Transparence</h3>
                    <p class="text-[#55493f] text-sm">Toutes nos transactions sont sécurisées et transparentes pour garantir la confiance.</p>
                </div>
                <div class="text-center p-6 bg-[#f8f6f3] rounded-lg hover:bg-green-50 transition-colors">
                    <div class="text-4xl mb-4">♻️</div>
                    <h3 class="font-semibold text-[#5c4033] mb-2">Durabilité</h3>
                    <p class="text-[#55493f] text-sm">Nous promouvons des pratiques agricoles respectueuses de l'environnement.</p>
                </div>
            </div>
        </div>

        <!-- Notre Équipe -->
        <div class="content-card fade-in">
            <h2 class="section-title-agri flex items-center">
                <span class="text-3xl mr-3">👥</span>
                Notre Équipe
            </h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-24 h-24 bg-gradient-to-br from-[#4CAF50] to-[#5c4033] rounded-full mx-auto mb-4 flex items-center justify-center text-white text-2xl font-bold">
                        AD
                    </div>
                    <h3 class="font-semibold text-[#5c4033]">Amadou Diallo</h3>
                    <p class="text-[#4CAF50] text-sm mb-2">Directeur Général</p>
                    <p class="text-[#55493f] text-sm">Expert en agriculture digitale avec 15 ans d'expérience</p>
                </div>
                <div class="text-center">
                    <div class="w-24 h-24 bg-gradient-to-br from-[#4CAF50] to-[#5c4033] rounded-full mx-auto mb-4 flex items-center justify-center text-white text-2xl font-bold">
                        FS
                    </div>
                    <h3 class="font-semibold text-[#5c4033]">Fatou Sow</h3>
                    <p class="text-[#4CAF50] text-sm mb-2">Directrice Technique</p>
                    <p class="text-[#55493f] text-sm">Spécialiste en développement durable et innovation agricole</p>
                </div>
                <div class="text-center">
                    <div class="w-24 h-24 bg-gradient-to-br from-[#4CAF50] to-[#5c4033] rounded-full mx-auto mb-4 flex items-center justify-center text-white text-2xl font-bold">
                        MK
                    </div>
                    <h3 class="font-semibold text-[#5c4033]">Mamadou Kane</h3>
                    <p class="text-[#4CAF50] text-sm mb-2">Responsable Commercial</p>
                    <p class="text-[#55493f] text-sm">Expert en développement de partenariats stratégiques</p>
                </div>
            </div>
        </div>

        <!-- Notre Impact -->
        <div class="content-card fade-in">
            <h2 class="section-title-agri flex items-center">
                <span class="text-3xl mr-3">📊</span>
                Notre Impact
            </h2>
            <div class="bg-[#f8f6f3] p-6 rounded-lg">
                <p class="text-[#55493f] mb-4 leading-relaxed">
                    Depuis notre lancement, AgriLink Sénégal a contribué à transformer l'écosystème agricole sénégalais en :
                </p>
                <ul class="space-y-3 text-[#55493f]">
                    <li class="flex items-start">
                        <span class="text-[#4CAF50] mr-3 mt-1">✓</span>
                        <span><strong>Augmentation des revenus</strong> : Nos agriculteurs partenaires ont vu leurs revenus augmenter de 35% en moyenne grâce à l'accès à de nouveaux marchés.</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-[#4CAF50] mr-3 mt-1">✓</span>
                        <span><strong>Optimisation des ressources</strong> : En mutualisant les matériels disponibles, nous réduisons les périodes d'inactivité et maximisons l'utilisation des équipements.</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-[#4CAF50] mr-3 mt-1">✓</span>
                        <span><strong>Adoption de technologies</strong> : Plus de 200 équipements modernes ont été mis à disposition via notre service de location.</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-[#4CAF50] mr-3 mt-1">✓</span>
                        <span><strong>Création d'emplois</strong> : Notre plateforme a contribué à créer plus de 150 emplois directs et indirects dans les zones rurales.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
