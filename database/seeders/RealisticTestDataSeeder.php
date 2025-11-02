<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Equipment;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class RealisticTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🌱 Création des données de test réalistes...');

        // Assurer que les rôles existent
        $roles = ['admin', 'buyer', 'producer', 'equipment_owner'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Créer les utilisateurs principaux
        $this->createMainUsers();

        // Créer des producteurs supplémentaires
        $this->createAdditionalProducers();

        // Créer des propriétaires de matériel supplémentaires
        $this->createAdditionalEquipmentOwners();

        // Créer les catégories si elles n'existent pas
        $this->createCategories();

        // Créer des produits réalistes
        $this->createRealisticProducts();

        // Créer des équipements réalistes
        $this->createRealisticEquipment();

        $this->command->info('✅ Données de test créées avec succès !');
    }

    private function createMainUsers()
    {
        $this->command->info('👥 Création des utilisateurs principaux...');

        // Alexandre Ndour - Admin - Rufisque
        $alexandre = User::updateOrCreate(
            ['email' => 'alexandre.ndour@agrilink.com'],
            [
                'name' => 'Alexandre Ndour',
                'password' => Hash::make('Alexandr3'),
                'phone' => '+221 77 123 45 67',
                'phone_verified' => true,
                'region' => 'Dakar',
                'ville' => 'Rufisque',
                'address_line1' => 'Rufisque, Dakar',
                'country' => 'Sénégal',
                'cni_verified' => true,
                'cni_verified_at' => now(),
                'is_suspended' => false,
                'email_verified_at' => now(),
            ]
        );
        if (!$alexandre->hasRole('admin')) {
            $alexandre->assignRole('admin');
        }
        $this->command->info('✅ Admin créé : Alexandre Ndour (Rufisque)');

        // Djibril Sow - Propriétaire Matériel - Thiès
        $djibril = User::updateOrCreate(
            ['email' => 'djibril.sow@agrilink.com'],
            [
                'name' => 'Djibril Sow',
                'password' => Hash::make('password123'),
                'phone' => '+221 77 234 56 78',
                'phone_verified' => true,
                'region' => 'Thiès',
                'ville' => 'Thiès',
                'address_line1' => 'Thiès, Sénégal',
                'country' => 'Sénégal',
                'company_name' => 'Sow Agri-Equipements',
                'siret' => 'SN78901234567890',
                'fleet_size' => 25,
                'cni_verified' => true,
                'cni_verified_at' => now(),
                'is_suspended' => false,
                'email_verified_at' => now(),
            ]
        );
        if (!$djibril->hasRole('equipment_owner')) {
            $djibril->assignRole('equipment_owner');
        }
        $this->command->info('✅ Propriétaire matériel créé : Djibril Sow (Thiès)');

        // Ibrahima Diallo - Producteur - Casamance
        $ibrahima = User::updateOrCreate(
            ['email' => 'ibrahima.diallo@agrilink.com'],
            [
                'name' => 'Ibrahima Diallo',
                'password' => Hash::make('password123'),
                'phone' => '+221 77 345 67 89',
                'phone_verified' => true,
                'region' => 'Ziguinchor',
                'ville' => 'Ziguinchor',
                'address_line1' => 'Casamance, Ziguinchor',
                'country' => 'Sénégal',
                'farm_name' => 'Ferme Diallo de Casamance',
                'farm_type' => 'Agriculture mixte',
                'cni_verified' => true,
                'cni_verified_at' => now(),
                'is_suspended' => false,
                'email_verified_at' => now(),
            ]
        );
        if (!$ibrahima->hasRole('producer')) {
            $ibrahima->assignRole('producer');
        }
        $this->command->info('✅ Producteur créé : Ibrahima Diallo (Casamance)');

        // Fatoumata Kamaté Soumaré - Acheteur - Kédougou
        $fatoumata = User::updateOrCreate(
            ['email' => 'fatoumata.kamate@agrilink.com'],
            [
                'name' => 'Fatoumata Kamaté Soumaré',
                'password' => Hash::make('password123'),
                'phone' => '+221 77 456 78 90',
                'phone_verified' => true,
                'region' => 'Kédougou',
                'ville' => 'Kédougou',
                'address_line1' => 'Kédougou, Sénégal',
                'country' => 'Sénégal',
                'billing_vat_number' => 'SN112233445566',
                'cni_verified' => true,
                'cni_verified_at' => now(),
                'is_suspended' => false,
                'email_verified_at' => now(),
            ]
        );
        if (!$fatoumata->hasRole('buyer')) {
            $fatoumata->assignRole('buyer');
        }
        $this->command->info('✅ Acheteur créé : Fatoumata Kamaté Soumaré (Kédougou)');
    }

    private function createAdditionalProducers()
    {
        $this->command->info('🌾 Création de producteurs supplémentaires...');

        $producers = [
            [
                'name' => 'Mamadou Ndiaye',
                'email' => 'mamadou.ndiaye@agrilink.com',
                'phone' => '+221 77 567 89 01',
                'region' => 'Saint-Louis',
                'ville' => 'Saint-Louis',
                'farm_name' => 'Ferme Ndiaye du Fleuve',
                'farm_type' => 'Culture maraîchère',
            ],
            [
                'name' => 'Awa Diop',
                'email' => 'awa.diop@agrilink.com',
                'phone' => '+221 77 678 90 12',
                'region' => 'Kaolack',
                'ville' => 'Kaolack',
                'farm_name' => 'Ferme Bio Diop',
                'farm_type' => 'Agriculture biologique',
            ],
            [
                'name' => 'Ousmane Ba',
                'email' => 'ousmane.ba@agrilink.com',
                'phone' => '+221 77 789 01 23',
                'region' => 'Diourbel',
                'ville' => 'Mbacké',
                'farm_name' => 'Ferme Ba de Mbacké',
                'farm_type' => 'Arachide et mil',
            ],
            [
                'name' => 'Mariama Fall',
                'email' => 'mariama.fall@agrilink.com',
                'phone' => '+221 77 890 12 34',
                'region' => 'Louga',
                'ville' => 'Louga',
                'farm_name' => 'Ferme Fall',
                'farm_type' => 'Céréales',
            ],
            [
                'name' => 'Cheikh Gueye',
                'email' => 'cheikh.gueye@agrilink.com',
                'phone' => '+221 77 901 23 45',
                'region' => 'Fatick',
                'ville' => 'Fatick',
                'farm_name' => 'Ferme Gueye',
                'farm_type' => 'Riz et mil',
            ],
        ];

        foreach ($producers as $producerData) {
            $producer = User::updateOrCreate(
                ['email' => $producerData['email']],
                [
                    'name' => $producerData['name'],
                    'password' => Hash::make('password123'),
                    'phone' => $producerData['phone'],
                    'phone_verified' => true,
                    'region' => $producerData['region'],
                    'ville' => $producerData['ville'],
                    'address_line1' => $producerData['ville'] . ', Sénégal',
                    'country' => 'Sénégal',
                    'farm_name' => $producerData['farm_name'],
                    'farm_type' => $producerData['farm_type'],
                    'cni_verified' => true,
                    'cni_verified_at' => now(),
                    'is_suspended' => false,
                    'email_verified_at' => now(),
                ]
            );
            if (!$producer->hasRole('producer')) {
                $producer->assignRole('producer');
            }
        }

        $this->command->info('✅ ' . count($producers) . ' producteurs supplémentaires créés');
    }

    private function createAdditionalEquipmentOwners()
    {
        $this->command->info('🚜 Création de propriétaires de matériel supplémentaires...');

        $owners = [
            [
                'name' => 'Abdoulaye Diouf',
                'email' => 'abdoulaye.diouf@agrilink.com',
                'phone' => '+221 77 012 34 56',
                'region' => 'Dakar',
                'ville' => 'Dakar',
                'company_name' => 'Diouf Tracteurs Services',
                'fleet_size' => 18,
            ],
            [
                'name' => 'Khadija Sarr',
                'email' => 'khadija.sarr@agrilink.com',
                'phone' => '+221 77 123 45 67',
                'region' => 'Tambacounda',
                'ville' => 'Tambacounda',
                'company_name' => 'Sarr Matériels Agricoles',
                'fleet_size' => 12,
            ],
            [
                'name' => 'Amadou Faye',
                'email' => 'amadou.faye@agrilink.com',
                'phone' => '+221 77 234 56 78',
                'region' => 'Matam',
                'ville' => 'Matam',
                'company_name' => 'Faye Équipements',
                'fleet_size' => 15,
            ],
        ];

        foreach ($owners as $ownerData) {
            $owner = User::updateOrCreate(
                ['email' => $ownerData['email']],
                [
                    'name' => $ownerData['name'],
                    'password' => Hash::make('password123'),
                    'phone' => $ownerData['phone'],
                    'phone_verified' => true,
                    'region' => $ownerData['region'],
                    'ville' => $ownerData['ville'],
                    'address_line1' => $ownerData['ville'] . ', Sénégal',
                    'country' => 'Sénégal',
                    'company_name' => $ownerData['company_name'],
                    'siret' => 'SN' . rand(10000000000000, 99999999999999),
                    'fleet_size' => $ownerData['fleet_size'],
                    'cni_verified' => true,
                    'cni_verified_at' => now(),
                    'is_suspended' => false,
                    'email_verified_at' => now(),
                ]
            );
            if (!$owner->hasRole('equipment_owner')) {
                $owner->assignRole('equipment_owner');
            }
        }

        $this->command->info('✅ ' . count($owners) . ' propriétaires de matériel supplémentaires créés');
    }

    private function createCategories()
    {
        // Catégories de produits
        $productCategories = [
            'Céréales' => 'Riz, mil, maïs, sorgho',
            'Légumineuses' => 'Arachides, haricots, niébé',
            'Fruits' => 'Mangues, bananes, pastèques',
            'Légumes' => 'Tomates, oignons, carottes, pommes de terre',
            'Racines et tubercules' => 'Manioc, patates douces, ignames',
            'Épices' => 'Piment, gingembre, curcuma',
        ];

        foreach ($productCategories as $name => $description) {
            Category::firstOrCreate(
                ['name' => $name, 'type' => 'product'],
                ['slug' => Str::slug($name)]
            );
        }

        // Catégories d'équipements
        $equipmentCategories = [
            'Tracteurs' => 'Tracteurs agricoles de différentes puissances',
            'Moissonneuses' => 'Moissonneuses-batteuses pour récolte',
            'Semoirs' => 'Matériel de semis',
            'Pulvérisateurs' => 'Équipement de traitement',
            'Matériel de labour' => 'Charrues, herses, cultivateurs',
            'Matériel d\'irrigation' => 'Pompes, systèmes d\'arrosage',
        ];

        foreach ($equipmentCategories as $name => $description) {
            Category::firstOrCreate(
                ['name' => $name, 'type' => 'equipment'],
                ['slug' => Str::slug($name)]
            );
        }

        $this->command->info('✅ Catégories créées');
    }

    private function createRealisticProducts()
    {
        $this->command->info('📦 Création de produits réalistes...');

        // Prix en USD (sera converti en FCFA dans l'app)
        // Prix moyens du marché sénégalais en 2024
        $products = [
            // Céréales
            [
                'title' => 'Riz blanc de Casamance - 50kg',
                'description' => 'Riz de qualité supérieure cultivé en Casamance, excellent goût et texture. Production locale et biologique.',
                'price' => 25000 / 655.957, // ~38 USD pour 25000 FCFA
                'stock' => 150,
                'category' => 'Céréales',
                'producer' => 'ibrahima.diallo@agrilink.com',
            ],
            [
                'title' => 'Mil local - 25kg',
                'description' => 'Mil de qualité, idéal pour la préparation du thieboudienne et autres plats traditionnels.',
                'price' => 8000 / 655.957, // ~12 USD pour 8000 FCFA
                'stock' => 200,
                'category' => 'Céréales',
                'producer' => 'ousmane.ba@agrilink.com',
            ],
            [
                'title' => 'Maïs jaune - 50kg',
                'description' => 'Maïs de qualité, adapté pour l\'alimentation animale et humaine.',
                'price' => 12000 / 655.957, // ~18 USD
                'stock' => 180,
                'category' => 'Céréales',
                'producer' => 'cheikh.gueye@agrilink.com',
            ],
            [
                'title' => 'Sorgho rouge - 25kg',
                'description' => 'Sorgho de qualité, riche en nutriments, parfait pour la préparation de bouillies.',
                'price' => 7500 / 655.957, // ~11 USD
                'stock' => 120,
                'category' => 'Céréales',
                'producer' => 'mariama.fall@agrilink.com',
            ],

            // Légumineuses
            [
                'title' => 'Arachides décortiquées - 10kg',
                'description' => 'Arachides de qualité premium, décortiquées à la main, idéales pour la production d\'huile.',
                'price' => 15000 / 655.957, // ~23 USD
                'stock' => 100,
                'category' => 'Légumineuses',
                'producer' => 'ousmane.ba@agrilink.com',
            ],
            [
                'title' => 'Haricots rouges - 25kg',
                'description' => 'Haricots rouges locaux, riches en protéines, parfaits pour les plats traditionnels.',
                'price' => 18000 / 655.957, // ~27 USD
                'stock' => 80,
                'category' => 'Légumineuses',
                'producer' => 'awa.diop@agrilink.com',
            ],
            [
                'title' => 'Niébé (pois à vache) - 25kg',
                'description' => 'Niébé de qualité, excellent pour l\'alimentation et la restauration des sols.',
                'price' => 14000 / 655.957, // ~21 USD
                'stock' => 90,
                'category' => 'Légumineuses',
                'producer' => 'mamadou.ndiaye@agrilink.com',
            ],

            // Fruits
            [
                'title' => 'Mangues Kent - Cagette 10kg',
                'description' => 'Mangues Kent sucrées et juteuses, récoltées à maturité, idéales pour la consommation directe.',
                'price' => 5000 / 655.957, // ~8 USD
                'stock' => 50,
                'category' => 'Fruits',
                'producer' => 'ibrahima.diallo@agrilink.com',
            ],
            [
                'title' => 'Pastèques - Pièce',
                'description' => 'Pastèques sucrées et rafraîchissantes, cultivées en pleine terre.',
                'price' => 2000 / 655.957, // ~3 USD
                'stock' => 200,
                'category' => 'Fruits',
                'producer' => 'mamadou.ndiaye@agrilink.com',
            ],
            [
                'title' => 'Bananes plantain - Régime',
                'description' => 'Régime de bananes plantain de qualité, parfait pour la cuisine.',
                'price' => 3500 / 655.957, // ~5 USD
                'stock' => 60,
                'category' => 'Fruits',
                'producer' => 'ibrahima.diallo@agrilink.com',
            ],

            // Légumes
            [
                'title' => 'Tomates fraîches - Cagette 15kg',
                'description' => 'Tomates rouges et charnues, récoltées fraîches, parfaites pour les sauces et salades.',
                'price' => 8000 / 655.957, // ~12 USD
                'stock' => 40,
                'category' => 'Légumes',
                'producer' => 'awa.diop@agrilink.com',
            ],
            [
                'title' => 'Oignons blancs - Filet 10kg',
                'description' => 'Oignons locaux, fermes et goûteux, excellent pour la cuisine sénégalaise.',
                'price' => 6000 / 655.957, // ~9 USD
                'stock' => 120,
                'category' => 'Légumes',
                'producer' => 'mamadou.ndiaye@agrilink.com',
            ],
            [
                'title' => 'Carottes - Filet 5kg',
                'description' => 'Carottes fraîches et croquantes, riches en vitamines.',
                'price' => 4000 / 655.957, // ~6 USD
                'stock' => 70,
                'category' => 'Légumes',
                'producer' => 'awa.diop@agrilink.com',
            ],
            [
                'title' => 'Pommes de terre - Filet 20kg',
                'description' => 'Pommes de terre de qualité, idéales pour frites et plats cuisinés.',
                'price' => 9000 / 655.957, // ~14 USD
                'stock' => 60,
                'category' => 'Légumes',
                'producer' => 'mariama.fall@agrilink.com',
            ],

            // Racines et tubercules
            [
                'title' => 'Manioc - 25kg',
                'description' => 'Manioc frais, parfait pour la préparation de l\'attiéké et autres plats.',
                'price' => 7000 / 655.957, // ~11 USD
                'stock' => 100,
                'category' => 'Racines et tubercules',
                'producer' => 'cheikh.gueye@agrilink.com',
            ],
            [
                'title' => 'Patates douces - Filet 10kg',
                'description' => 'Patates douces de qualité, sucrées et nutritives.',
                'price' => 5000 / 655.957, // ~8 USD
                'stock' => 80,
                'category' => 'Racines et tubercules',
                'producer' => 'ibrahima.diallo@agrilink.com',
            ],

            // Épices
            [
                'title' => 'Piment fort - Sachet 1kg',
                'description' => 'Piment fort local, très épicé, parfait pour relever vos plats.',
                'price' => 3000 / 655.957, // ~5 USD
                'stock' => 150,
                'category' => 'Épices',
                'producer' => 'awa.diop@agrilink.com',
            ],
            [
                'title' => 'Gingembre frais - 1kg',
                'description' => 'Gingembre frais et aromatique, excellent pour la cuisine et les infusions.',
                'price' => 2500 / 655.957, // ~4 USD
                'stock' => 100,
                'category' => 'Épices',
                'producer' => 'ousmane.ba@agrilink.com',
            ],
        ];

        foreach ($products as $productData) {
            $category = Category::where('name', $productData['category'])
                ->where('type', 'product')
                ->first();

            $producer = User::where('email', $productData['producer'])->first();

            if ($category && $producer) {
                Product::updateOrCreate(
                    [
                        'title' => $productData['title'],
                        'user_id' => $producer->id,
                    ],
                    [
                        'description' => $productData['description'],
                        'price' => $productData['price'],
                        'stock' => $productData['stock'],
                        'category_id' => $category->id,
                        'is_active' => true,
                    ]
                );
            }
        }

        $this->command->info('✅ ' . count($products) . ' produits créés');
    }

    private function createRealisticEquipment()
    {
        $this->command->info('🚜 Création d\'équipements réalistes...');

        // Prix de location par jour en USD (sera converti en FCFA)
        // Prix moyens du marché sénégalais pour location de matériel agricole
        $equipment = [
            // Tracteurs
            [
                'title' => 'Tracteur Massey Ferguson 375 - 75CV',
                'description' => 'Tracteur agricole robuste de 75CV, idéal pour le labour, le semis et la récolte. État excellent, bien entretenu. Inclut opérateur expérimenté si nécessaire.',
                'daily_rate' => 80000 / 655.957, // ~122 USD/jour
                'location' => 'Thiès, Sénégal',
                'category' => 'Tracteurs',
                'owner' => 'djibril.sow@agrilink.com',
            ],
            [
                'title' => 'Tracteur New Holland TD90 - 90CV',
                'description' => 'Tracteur puissant de 90CV, équipé de système hydraulique moderne. Parfait pour grandes exploitations.',
                'daily_rate' => 100000 / 655.957, // ~152 USD/jour
                'location' => 'Dakar, Sénégal',
                'category' => 'Tracteurs',
                'owner' => 'abdoulaye.diouf@agrilink.com',
            ],
            [
                'title' => 'Tracteur John Deere 5055D - 55CV',
                'description' => 'Tracteur compact et polyvalent, économique en carburant. Idéal pour petites et moyennes exploitations.',
                'daily_rate' => 60000 / 655.957, // ~91 USD/jour
                'location' => 'Tambacounda, Sénégal',
                'category' => 'Tracteurs',
                'owner' => 'khadija.sarr@agrilink.com',
            ],

            // Moissonneuses
            [
                'title' => 'Moissonneuse-batteuse Claas Dominator 108',
                'description' => 'Moissonneuse-batteuse performante, adaptée aux récoltes de céréales (riz, mil, maïs). Très efficace et rapide.',
                'daily_rate' => 200000 / 655.957, // ~305 USD/jour
                'location' => 'Thiès, Sénégal',
                'category' => 'Moissonneuses',
                'owner' => 'djibril.sow@agrilink.com',
            ],
            [
                'title' => 'Moissonneuse-batteuse New Holland TC56',
                'description' => 'Machine moderne pour récolte de céréales, largeur de coupe 5.6m. Opérateur qualifié disponible.',
                'daily_rate' => 180000 / 655.957, // ~274 USD/jour
                'location' => 'Dakar, Sénégal',
                'category' => 'Moissonneuses',
                'owner' => 'abdoulaye.diouf@agrilink.com',
            ],

            // Semoirs
            [
                'title' => 'Semoir pneumatique 4 rangs',
                'description' => 'Semoir précis pour semis de céréales et légumineuses. Réglage précis de la profondeur et de l\'espacement.',
                'daily_rate' => 25000 / 655.957, // ~38 USD/jour
                'location' => 'Thiès, Sénégal',
                'category' => 'Semoirs',
                'owner' => 'djibril.sow@agrilink.com',
            ],
            [
                'title' => 'Semoir à disques 6 rangs',
                'description' => 'Semoir robuste pour grandes surfaces, idéal pour mil, maïs et arachides.',
                'daily_rate' => 35000 / 655.957, // ~53 USD/jour
                'location' => 'Matam, Sénégal',
                'category' => 'Semoirs',
                'owner' => 'amadou.faye@agrilink.com',
            ],

            // Pulvérisateurs
            [
                'title' => 'Pulvérisateur porté 600L',
                'description' => 'Pulvérisateur à rampe de 12m, pour traitement phytosanitaire efficace. Excellente couverture.',
                'daily_rate' => 20000 / 655.957, // ~30 USD/jour
                'location' => 'Thiès, Sénégal',
                'category' => 'Pulvérisateurs',
                'owner' => 'djibril.sow@agrilink.com',
            ],
            [
                'title' => 'Pulvérisateur traîné 1000L',
                'description' => 'Grande capacité pour traitement de grandes parcelles. Rampe de 18m.',
                'daily_rate' => 30000 / 655.957, // ~46 USD/jour
                'location' => 'Dakar, Sénégal',
                'category' => 'Pulvérisateurs',
                'owner' => 'abdoulaye.diouf@agrilink.com',
            ],

            // Matériel de labour
            [
                'title' => 'Charrue réversible 5 corps',
                'description' => 'Charrue robuste pour labour profond, 5 corps. Idéale pour préparation des sols.',
                'daily_rate' => 30000 / 655.957, // ~46 USD/jour
                'location' => 'Thiès, Sénégal',
                'category' => 'Matériel de labour',
                'owner' => 'djibril.sow@agrilink.com',
            ],
            [
                'title' => 'Herse rotative 2m',
                'description' => 'Herse rotative pour affinage du sol après labour. Excellent résultat.',
                'daily_rate' => 25000 / 655.957, // ~38 USD/jour
                'location' => 'Tambacounda, Sénégal',
                'category' => 'Matériel de labour',
                'owner' => 'khadija.sarr@agrilink.com',
            ],
            [
                'title' => 'Cultivateur à dents 3m',
                'description' => 'Cultivateur pour travail superficiel du sol, désherbage mécanique.',
                'daily_rate' => 22000 / 655.957, // ~34 USD/jour
                'location' => 'Matam, Sénégal',
                'category' => 'Matériel de labour',
                'owner' => 'amadou.faye@agrilink.com',
            ],

            // Matériel d'irrigation
            [
                'title' => 'Pompe d\'irrigation diesel 4 pouces',
                'description' => 'Pompe puissante pour irrigation de grandes surfaces. Débit élevé, très fiable.',
                'daily_rate' => 15000 / 655.957, // ~23 USD/jour
                'location' => 'Thiès, Sénégal',
                'category' => 'Matériel d\'irrigation',
                'owner' => 'djibril.sow@agrilink.com',
            ],
            [
                'title' => 'Système d\'arrosage goutte-à-goutte 1 hectare',
                'description' => 'Installation complète d\'irrigation goutte-à-goutte pour 1 hectare. Très économique en eau.',
                'daily_rate' => 12000 / 655.957, // ~18 USD/jour
                'location' => 'Dakar, Sénégal',
                'category' => 'Matériel d\'irrigation',
                'owner' => 'abdoulaye.diouf@agrilink.com',
            ],
        ];

        foreach ($equipment as $equipmentData) {
            $category = Category::where('name', $equipmentData['category'])
                ->where('type', 'equipment')
                ->first();

            $owner = User::where('email', $equipmentData['owner'])->first();

            if ($category && $owner) {
                Equipment::updateOrCreate(
                    [
                        'title' => $equipmentData['title'],
                        'user_id' => $owner->id,
                    ],
                    [
                        'description' => $equipmentData['description'],
                        'daily_rate' => $equipmentData['daily_rate'],
                        'location' => $equipmentData['location'],
                        'category_id' => $category->id,
                        'is_active' => true,
                        'is_available' => true,
                        'pricing_unit' => 'per_day',
                    ]
                );
            }
        }

        $this->command->info('✅ ' . count($equipment) . ' équipements créés');
    }
}
