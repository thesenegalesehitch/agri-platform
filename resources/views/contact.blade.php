<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Contactez-nous
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Informations de Contact -->
                <div class="space-y-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <span class="text-3xl mr-3">📞</span>
                                Contactez-nous
                            </h2>
                            <p class="text-gray-600 mb-6">
                                Notre équipe est à votre disposition pour répondre à toutes vos questions sur Agri-Platform Sénégal.
                            </p>

                            <div class="space-y-4">
                                <div class="flex items-center p-4 bg-green-50 rounded-lg">
                                    <div class="text-2xl mr-4">📍</div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">Adresse</h3>
                                        <p class="text-gray-600">123 Avenue de l'Agriculture<br>Dakar, Sénégal</p>
                                    </div>
                                </div>

                                <div class="flex items-center p-4 bg-blue-50 rounded-lg">
                                    <div class="text-2xl mr-4">📞</div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">Téléphone</h3>
                                        <p class="text-gray-600">+221 77 123 45 67</p>
                                    </div>
                                </div>

                                <div class="flex items-center p-4 bg-purple-50 rounded-lg">
                                    <div class="text-2xl mr-4">✉️</div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">Email</h3>
                                        <p class="text-gray-600">contact@agriplatform.sn</p>
                                    </div>
                                </div>

                                <div class="flex items-center p-4 bg-orange-50 rounded-lg">
                                    <div class="text-2xl mr-4">🕒</div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">Horaires</h3>
                                        <p class="text-gray-600">Lundi - Vendredi: 8h00 - 18h00<br>Samedi: 9h00 - 14h00</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Support Technique -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-8">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <span class="text-2xl mr-3">🛠️</span>
                                Support Technique
                            </h3>
                            <p class="text-gray-600 mb-4">
                                Besoin d'aide avec votre compte ou notre plateforme ?
                            </p>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                    <span class="text-sm font-medium">Chat en ligne</span>
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Disponible</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                    <span class="text-sm font-medium">Email support</span>
                                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">24h</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                    <span class="text-sm font-medium">Téléphone</span>
                                    <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded">9h-17h</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulaire de Contact -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                            <span class="text-2xl mr-3">💬</span>
                            Envoyez-nous un message
                        </h3>

                        <form class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Prénom</label>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Votre prénom">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Votre nom">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="votre.email@example.com">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                                <input type="tel" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="+221 77 XXX XX XX">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Sujet</label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    <option>Choisissez un sujet</option>
                                    <option>Support technique</option>
                                    <option>Questions commerciales</option>
                                    <option>Partenariats</option>
                                    <option>Signaler un problème</option>
                                    <option>Autres</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                                <textarea rows="5" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Votre message..."></textarea>
                            </div>

                            <button type="submit" class="w-full bg-green-600 text-white py-3 px-4 rounded-md hover:bg-green-700 transition-colors font-medium">
                                Envoyer le message
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="mt-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="text-2xl mr-3">❓</span>
                        Questions Fréquentes
                    </h3>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="border-l-4 border-green-500 pl-4">
                                <h4 class="font-semibold text-gray-800 mb-2">Comment créer un compte ?</h4>
                                <p class="text-gray-600 text-sm">Cliquez sur "Créer un compte" et remplissez le formulaire avec vos informations personnelles.</p>
                            </div>

                            <div class="border-l-4 border-blue-500 pl-4">
                                <h4 class="font-semibold text-gray-800 mb-2">Comment ajouter un produit ?</h4>
                                <p class="text-gray-600 text-sm">Connectez-vous à votre compte producteur et utilisez le bouton "Nouveau" dans la section Produits.</p>
                            </div>

                            <div class="border-l-4 border-purple-500 pl-4">
                                <h4 class="font-semibold text-gray-800 mb-2">Comment louer un équipement ?</h4>
                                <p class="text-gray-600 text-sm">Parcourez les équipements disponibles et cliquez sur "Demander une location" pour le matériel souhaité.</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="border-l-4 border-orange-500 pl-4">
                                <h4 class="font-semibold text-gray-800 mb-2">Quels sont les frais de service ?</h4>
                                <p class="text-gray-600 text-sm">Nous appliquons une commission de 5% sur les transactions réussies pour maintenir la plateforme.</p>
                            </div>

                            <div class="border-l-4 border-red-500 pl-4">
                                <h4 class="font-semibold text-gray-800 mb-2">Comment contacter le support ?</h4>
                                <p class="text-gray-600 text-sm">Utilisez le formulaire ci-dessus ou appelez-nous au +221 77 123 45 67.</p>
                            </div>

                            <div class="border-l-4 border-indigo-500 pl-4">
                                <h4 class="font-semibold text-gray-800 mb-2">Les paiements sont-ils sécurisés ?</h4>
                                <p class="text-gray-600 text-sm">Oui, toutes les transactions sont sécurisées avec un système de paiement certifié.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Réseaux Sociaux -->
            <div class="mt-8 bg-gradient-to-r from-green-600 to-green-800 rounded-lg p-8 text-white text-center">
                <h3 class="text-xl font-bold mb-4">Suivez-nous sur les réseaux sociaux</h3>
                <p class="mb-6 opacity-90">Restez informé de nos dernières actualités et innovations</p>
                <div class="flex justify-center space-x-6">
                    <a href="#" class="text-white hover:text-green-200 transition-colors">
                        <span class="text-3xl">📘</span>
                        <span class="block text-sm mt-1">Facebook</span>
                    </a>
                    <a href="#" class="text-white hover:text-green-200 transition-colors">
                        <span class="text-3xl">🐦</span>
                        <span class="block text-sm mt-1">Twitter</span>
                    </a>
                    <a href="#" class="text-white hover:text-green-200 transition-colors">
                        <span class="text-3xl">📷</span>
                        <span class="block text-sm mt-1">Instagram</span>
                    </a>
                    <a href="#" class="text-white hover:text-green-200 transition-colors">
                        <span class="text-3xl">💼</span>
                        <span class="block text-sm mt-1">LinkedIn</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>