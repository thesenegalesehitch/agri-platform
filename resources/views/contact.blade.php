<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title-agri">Contactez-nous</h2>
    </x-slot>

    <div class="grid md:grid-cols-2 gap-6">
        <!-- Informations de Contact -->
        <div class="space-y-6">
            <div class="content-card fade-in">
                <h2 class="section-title-agri flex items-center">
                    <span class="text-3xl mr-3">📞</span>
                    Contactez-nous
                </h2>
                <p class="text-[#55493f] mb-6">
                    Notre équipe est à votre disposition pour répondre à toutes vos questions sur AgriLink Sénégal.
                </p>

                <div class="space-y-4">
                    <div class="flex items-center p-4 bg-[#f8f6f3] rounded-lg">
                        <div class="text-2xl mr-4">📍</div>
                        <div>
                            <h3 class="font-semibold text-[#5c4033]">Adresse</h3>
                            <p class="text-[#55493f]">123 Avenue de l'Agriculture<br>Dakar, Sénégal</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-[#f8f6f3] rounded-lg">
                        <div class="text-2xl mr-4">📞</div>
                        <div>
                            <h3 class="font-semibold text-[#5c4033]">Téléphone</h3>
                            <p class="text-[#55493f]">+221 77 123 45 67</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-[#f8f6f3] rounded-lg">
                        <div class="text-2xl mr-4">✉️</div>
                        <div>
                            <h3 class="font-semibold text-[#5c4033]">Email</h3>
                            <p class="text-[#55493f]">contact@agriplatform.sn</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-[#f8f6f3] rounded-lg">
                        <div class="text-2xl mr-4">🕒</div>
                        <div>
                            <h3 class="font-semibold text-[#5c4033]">Horaires</h3>
                            <p class="text-[#55493f]">Lundi - Vendredi: 8h00 - 18h00<br>Samedi: 9h00 - 14h00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire de Contact -->
        <div class="content-card fade-in">
            <h3 class="section-title-agri flex items-center">
                <span class="text-2xl mr-3">💬</span>
                Envoyez-nous un message
            </h3>

            <form class="space-y-6">
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label class="form-label-agri">Prénom</label>
                        <input type="text" class="form-input-agri" placeholder="Votre prénom">
                    </div>
                    <div class="form-group">
                        <label class="form-label-agri">Nom</label>
                        <input type="text" class="form-input-agri" placeholder="Votre nom">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label-agri">Email</label>
                    <input type="email" class="form-input-agri" placeholder="votre.email@example.com">
                </div>

                <div class="form-group">
                    <label class="form-label-agri">Téléphone</label>
                    <input type="tel" class="form-input-agri" placeholder="+221 77 XXX XX XX">
                </div>

                <div class="form-group">
                    <label class="form-label-agri">Sujet</label>
                    <select class="form-select-agri">
                        <option>Choisissez un sujet</option>
                        <option>Support technique</option>
                        <option>Questions commerciales</option>
                        <option>Partenariats</option>
                        <option>Signaler un problème</option>
                        <option>Autres</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label-agri">Message</label>
                    <textarea rows="5" class="form-textarea-agri" placeholder="Votre message..."></textarea>
                </div>

                <button type="submit" class="btn-primary-agri w-full">
                    📧 Envoyer le message
                </button>
            </form>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="content-card fade-in mt-6">
        <h3 class="section-title-agri flex items-center">
            <span class="text-2xl mr-3">❓</span>
            Questions Fréquentes
        </h3>

        <div class="grid md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="border-l-4 border-[#4CAF50] pl-4">
                    <h4 class="font-semibold text-[#5c4033] mb-2">Comment créer un compte ?</h4>
                    <p class="text-[#55493f] text-sm">Cliquez sur "Créer un compte" et remplissez le formulaire avec vos informations personnelles.</p>
                </div>

                <div class="border-l-4 border-[#4CAF50] pl-4">
                    <h4 class="font-semibold text-[#5c4033] mb-2">Comment louer un équipement ?</h4>
                    <p class="text-[#55493f] text-sm">Parcourez les équipements disponibles et cliquez sur "Demander une location" pour le matériel souhaité.</p>
                </div>

                <div class="border-l-4 border-[#4CAF50] pl-4">
                    <h4 class="font-semibold text-[#5c4033] mb-2">Comment proposer mon matériel ?</h4>
                    <p class="text-[#55493f] text-sm">Connectez-vous à votre espace propriétaire et ajoutez un nouveau matériel avec ses caractéristiques et tarifs.</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="border-l-4 border-[#4CAF50] pl-4">
                    <h4 class="font-semibold text-[#5c4033] mb-2">Quels sont les frais de service ?</h4>
                    <p class="text-[#55493f] text-sm">Nous appliquons une commission de 5% sur les transactions réussies pour maintenir la plateforme.</p>
                </div>

                <div class="border-l-4 border-[#4CAF50] pl-4">
                    <h4 class="font-semibold text-[#5c4033] mb-2">Comment contacter le support ?</h4>
                    <p class="text-[#55493f] text-sm">Utilisez le formulaire ci-dessus ou appelez-nous au +221 77 123 45 67.</p>
                </div>

                <div class="border-l-4 border-[#4CAF50] pl-4">
                    <h4 class="font-semibold text-[#5c4033] mb-2">Les paiements sont-ils sécurisés ?</h4>
                    <p class="text-[#55493f] text-sm">Oui, toutes les transactions sont sécurisées avec un système de paiement certifié.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
