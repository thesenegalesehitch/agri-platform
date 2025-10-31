<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Equipment;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ProductAndEquipmentSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer un producteur et un propriétaire de matériel
        $producer = User::whereHas('roles', fn($q) => $q->where('name', 'producer'))->first();
        $equipmentOwner = User::whereHas('roles', fn($q) => $q->where('name', 'equipment_owner'))->first();

        // Créer les rôles s'ils n'existent pas
        Role::firstOrCreate(['name' => 'producer']);
        Role::firstOrCreate(['name' => 'equipment_owner']);

        if (!$producer) {
            $this->command->warn('Aucun producteur trouvé. Création d\'un producteur de test...');
            $producer = User::firstOrCreate(
                ['email' => 'producer-test@agri-platform.com'],
                [
                    'name' => 'Producteur Test',
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                ]
            );
            if (!$producer->hasRole('producer')) {
                $producer->assignRole('producer');
            }
        }

        if (!$equipmentOwner) {
            $this->command->warn('Aucun propriétaire de matériel trouvé. Création d\'un propriétaire de test...');
            $equipmentOwner = User::firstOrCreate(
                ['email' => 'owner-test@agri-platform.com'],
                [
                    'name' => 'Propriétaire Matériel Test',
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                ]
            );
            if (!$equipmentOwner->hasRole('equipment_owner')) {
                $equipmentOwner->assignRole('equipment_owner');
            }
        }

        // Créer ou récupérer les catégories de produits
        $fruits = Category::firstOrCreate(
            ['slug' => 'fruits', 'type' => 'product'],
            ['name' => 'Fruits', 'type' => 'product']
        );
        $legumes = Category::firstOrCreate(
            ['slug' => 'legumes', 'type' => 'product'],
            ['name' => 'Légumes', 'type' => 'product']
        );
        $aromates = Category::firstOrCreate(
            ['slug' => 'aromates', 'type' => 'product'],
            ['name' => 'Aromates', 'type' => 'product']
        );

        // Créer ou récupérer les catégories de matériels
        $travailDuSol = Category::firstOrCreate(
            ['slug' => 'travail-du-sol', 'type' => 'equipment'],
            ['name' => 'Travail du Sol', 'type' => 'equipment']
        );
        $semisPlantation = Category::firstOrCreate(
            ['slug' => 'semis-plantation', 'type' => 'equipment'],
            ['name' => 'Semis & Plantation', 'type' => 'equipment']
        );
        $entretienDesherbage = Category::firstOrCreate(
            ['slug' => 'entretien-desherbage', 'type' => 'equipment'],
            ['name' => 'Entretien & Désherbage', 'type' => 'equipment']
        );
        $irrigation = Category::firstOrCreate(
            ['slug' => 'irrigation', 'type' => 'equipment'],
            ['name' => 'Irrigation', 'type' => 'equipment']
        );
        $recolte = Category::firstOrCreate(
            ['slug' => 'recolte', 'type' => 'equipment'],
            ['name' => 'Récolte', 'type' => 'equipment']
        );
        $logistiqueTransport = Category::firstOrCreate(
            ['slug' => 'logistique-transport', 'type' => 'equipment'],
            ['name' => 'Logistique & Transport', 'type' => 'equipment']
        );

        // PRODUITS - Fruits (9 produits)
        // Note: pricing_unit utilise l'enum: 'per_unit', 'per_kilo', 'per_hectare', 'per_hour', 'per_day'
        $fruitsProducts = [
            ['Mangue', 'Mangues fraîches et sucrées de qualité supérieure. Variétés variées disponibles.', 1800, 'per_kilo'],
            ['Banane', 'Bananes mûres et savoureuses, parfaites pour la consommation ou la transformation.', 1200, 'per_kilo'],
            ['Orange', 'Oranges juteuses et vitaminées, récoltées à maturité optimale.', 1500, 'per_kilo'],
            ['Citron', 'Citrons frais et acidulés, idéaux pour la cuisine et les boissons.', 2000, 'per_kilo'],
            ['Papaye', 'Papayes mûres et sucrées, riches en vitamines et antioxydants.', 1400, 'per_unit'],
            ['Ananas', 'Ananas frais et sucrés, parfaitement mûrs. Qualité export.', 2200, 'per_unit'],
            ['Pastèque', 'Pastèques juteuses et rafraîchissantes, idéales pour la saison chaude.', 1000, 'per_unit'],
            ['Goyave', 'Goyaves parfumées et riches en vitamine C. Produits locaux de qualité.', 1300, 'per_kilo'],
            ['Dattes', 'Dattes séchées sucrées, parfaites pour le goûter et la pâtisserie.', 3500, 'per_kilo'],
        ];

        // PRODUITS - Légumes (9 produits)
        $legumesProducts = [
            ['Tomate', 'Tomates fraîches et charnues, récoltées quotidiennement. Parfaites pour la cuisine sénégalaise.', 800, 'per_kilo'],
            ['Oignon', 'Oignons secs de qualité, bien conservés. Essentiels pour la cuisine locale.', 700, 'per_kilo'],
            ['Poivron', 'Poivrons colorés (rouge, vert, jaune) frais et croquants.', 1500, 'per_kilo'],
            ['Piment', 'Piments forts locaux, frais ou séchés selon disponibilité.', 2500, 'per_kilo'],
            ['Aubergine', 'Aubergines violettes fraîches, idéales pour les plats traditionnels.', 1000, 'per_kilo'],
            ['Gombo', 'Gombos frais et tendres, parfaits pour les sauces et plats locaux.', 1200, 'per_kilo'],
            ['Carotte', 'Carottes fraîches et croquantes, riches en bêta-carotène.', 1100, 'per_kilo'],
            ['Chou', 'Choux verts frais, parfaits pour les salades et plats cuisinés.', 900, 'per_unit'],
            ['Laitue', 'Laitues fraîches et croquantes, idéales pour les salades.', 1500, 'per_unit'],
        ];

        // PRODUITS - Aromates (5 produits)
        $aromatesProducts = [
            ['Ail', 'Ail frais, gousses bien formées et parfumées. Essentiel pour la cuisine.', 3000, 'per_kilo'],
            ['Gingembre', 'Gingembre frais et piquant, excellent pour la santé et la cuisine.', 4000, 'per_kilo'],
            ['Persil', 'Persil frais, feuilles tendres et parfumées. Cueillette quotidienne.', 2500, 'per_unit'],
            ['Menthe', 'Menthe fraîche et aromatique, parfaite pour le thé et les boissons.', 2000, 'per_unit'],
            ['Basilic', 'Basilic frais et parfumé, idéal pour les sauces et plats méditerranéens.', 2200, 'per_unit'],
        ];

        // Créer tous les produits
        $allProducts = [];
        
        foreach ($fruitsProducts as [$title, $description, $price, $unit]) {
            $allProducts[] = [
                'user_id' => $producer->id,
                'category_id' => $fruits->id,
                'title' => $title,
                'description' => $description,
                'price' => $price,
                'stock' => rand(50, 300),
                'pricing_unit' => $unit,
                'is_active' => true,
            ];
        }

        foreach ($legumesProducts as [$title, $description, $price, $unit]) {
            $allProducts[] = [
                'user_id' => $producer->id,
                'category_id' => $legumes->id,
                'title' => $title,
                'description' => $description,
                'price' => $price,
                'stock' => rand(50, 300),
                'pricing_unit' => $unit,
                'is_active' => true,
            ];
        }

        foreach ($aromatesProducts as [$title, $description, $price, $unit]) {
            $allProducts[] = [
                'user_id' => $producer->id,
                'category_id' => $aromates->id,
                'title' => $title,
                'description' => $description,
                'price' => $price,
                'stock' => rand(20, 150),
                'pricing_unit' => $unit,
                'is_active' => true,
            ];
        }

        foreach ($allProducts as $productData) {
            Product::firstOrCreate(
                [
                    'user_id' => $productData['user_id'],
                    'title' => $productData['title'],
                ],
                $productData
            );
        }

        // MATÉRIELS - Travail du Sol (3 matériels)
        $equipmentTravailSol = [
            [
                'title' => 'Tracteur (50-90 CV)',
                'description' => 'Force motrice pour le labour, le transport et le remorquage d\'outils. Puissance 50-90 CV, idéal pour les exploitations moyennes à grandes.',
                'daily_rate' => 75000,
                'location' => 'Thiès, Sénégal',
            ],
            [
                'title' => 'Charrue (à disques ou à socs)',
                'description' => 'Retournement et aération du sol (labour). Disponible en version à disques ou à socs selon le type de sol.',
                'daily_rate' => 18000,
                'location' => 'Kaolack, Sénégal',
            ],
            [
                'title' => 'Herse (à disques ou rotative)',
                'description' => 'Émiettement et nivellement du sol après le labour. Préparation fine du lit de semence.',
                'daily_rate' => 15000,
                'location' => 'Saint-Louis, Sénégal',
            ],
        ];

        // MATÉRIELS - Semis & Plantation (1 matériel)
        $equipmentSemis = [
            [
                'title' => 'Semoir / Planteur',
                'description' => 'Dépôt précis des graines (arachide, maïs, mil) ou des plants. Réglage de l\'espacement et de la profondeur ajustable.',
                'daily_rate' => 20000,
                'location' => 'Louga, Sénégal',
            ],
        ];

        // MATÉRIELS - Entretien & Désherbage (2 matériels)
        $equipmentEntretien = [
            [
                'title' => 'Bineuse / Cultivateur',
                'description' => 'Sarclage mécanique entre les lignes pour lutter contre les mauvaises herbes. Évite l\'utilisation d\'herbicides.',
                'daily_rate' => 12000,
                'location' => 'Ziguinchor, Sénégal',
            ],
            [
                'title' => 'Pulvérisateur (Traîné ou Porté)',
                'description' => 'Application de produits phytosanitaires (herbicides, pesticides) ou d\'engrais. Disponible en version traînée ou portée.',
                'daily_rate' => 18000,
                'location' => 'Dakar, Sénégal',
            ],
        ];

        // MATÉRIELS - Irrigation (2 matériels)
        $equipmentIrrigation = [
            [
                'title' => 'Motopompe',
                'description' => 'Pompage de l\'eau (puits, forages, cours d\'eau) pour l\'irrigation. Puissance et débit adaptés à vos besoins.',
                'daily_rate' => 15000,
                'location' => 'Tambacounda, Sénégal',
            ],
            [
                'title' => 'Systèmes d\'irrigation mobiles',
                'description' => 'Tuyaux, asperseurs, ou systèmes goutte-à-goutte temporaires. Installation rapide et flexible.',
                'daily_rate' => 10000,
                'location' => 'Kolda, Sénégal',
            ],
        ];

        // MATÉRIELS - Récolte (3 matériels)
        $equipmentRecolte = [
            [
                'title' => 'Moissonneuse-Batteuse',
                'description' => 'Récolte et battage simultanés de céréales (riz, maïs) ou de légumineuses. Gain de temps considérable.',
                'daily_rate' => 120000,
                'location' => 'Matam, Sénégal',
            ],
            [
                'title' => 'Décortiqueuse / Égreneuse',
                'description' => 'Séparation des grains de leurs coques (arachide) ou épis (maïs) après la récolte. Rendement élevé.',
                'daily_rate' => 25000,
                'location' => 'Fatick, Sénégal',
            ],
            [
                'title' => 'Presse à Balles (Botteleuse)',
                'description' => 'Compactage de la paille ou du fourrage en balles pour le transport et le stockage. Pratique et efficace.',
                'daily_rate' => 22000,
                'location' => 'Diourbel, Sénégal',
            ],
        ];

        // MATÉRIELS - Logistique & Transport (2 matériels)
        $equipmentLogistique = [
            [
                'title' => 'Remorque Agricole',
                'description' => 'Transport des récoltes, du fumier, des équipements ou des intrants. Capacité de charge adaptée.',
                'daily_rate' => 15000,
                'location' => 'Sédhiou, Sénégal',
            ],
            [
                'title' => 'Camion-Citerne',
                'description' => 'Transport de grandes quantités d\'eau sur le site. Idéal pour l\'irrigation ou l\'abreuvement du bétail.',
                'daily_rate' => 35000,
                'location' => 'Kaffrine, Sénégal',
            ],
        ];

        // Créer tous les matériels
        $allEquipment = [];

        foreach ($equipmentTravailSol as $eq) {
            $allEquipment[] = array_merge($eq, [
                'user_id' => $equipmentOwner->id,
                'category_id' => $travailDuSol->id,
                'pricing_unit' => 'per_day',
                'is_available' => true,
                'is_active' => true,
            ]);
        }

        foreach ($equipmentSemis as $eq) {
            $allEquipment[] = array_merge($eq, [
                'user_id' => $equipmentOwner->id,
                'category_id' => $semisPlantation->id,
                'pricing_unit' => 'per_day',
                'is_available' => true,
                'is_active' => true,
            ]);
        }

        foreach ($equipmentEntretien as $eq) {
            $allEquipment[] = array_merge($eq, [
                'user_id' => $equipmentOwner->id,
                'category_id' => $entretienDesherbage->id,
                'pricing_unit' => 'per_day',
                'is_available' => true,
                'is_active' => true,
            ]);
        }

        foreach ($equipmentIrrigation as $eq) {
            $allEquipment[] = array_merge($eq, [
                'user_id' => $equipmentOwner->id,
                'category_id' => $irrigation->id,
                'pricing_unit' => 'per_day',
                'is_available' => true,
                'is_active' => true,
            ]);
        }

        foreach ($equipmentRecolte as $eq) {
            $allEquipment[] = array_merge($eq, [
                'user_id' => $equipmentOwner->id,
                'category_id' => $recolte->id,
                'pricing_unit' => 'per_day',
                'is_available' => true,
                'is_active' => true,
            ]);
        }

        foreach ($equipmentLogistique as $eq) {
            $allEquipment[] = array_merge($eq, [
                'user_id' => $equipmentOwner->id,
                'category_id' => $logistiqueTransport->id,
                'pricing_unit' => 'per_day',
                'is_available' => true,
                'is_active' => true,
            ]);
        }

        foreach ($allEquipment as $equipmentData) {
            Equipment::firstOrCreate(
                [
                    'user_id' => $equipmentData['user_id'],
                    'title' => $equipmentData['title'],
                ],
                $equipmentData
            );
        }

        $this->command->info('✅ ' . count($allProducts) . ' produits créés (Fruits: 9, Légumes: 9, Aromates: 5)');
        $this->command->info('✅ ' . count($allEquipment) . ' matériels créés (Travail du Sol: 3, Semis: 1, Entretien: 2, Irrigation: 2, Récolte: 3, Logistique: 2)');
    }
}
