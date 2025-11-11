<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure roles exist for reference accounts
        Role::firstOrCreate(['name' => 'producer']);
        Role::firstOrCreate(['name' => 'equipment_owner']);

        // Create or retrieve a reference equipment owner
        $owner = User::firstOrCreate(
            ['email' => 'owner@agri-platform.com'],
            [
                'name' => 'Mamadou Ndiaye',
                'password' => bcrypt('owner123'),
                'phone' => '+221 77 456 78 90',
                'address_line1' => 'Kaolack, Sénégal',
                'company_name' => 'Agri-Equip Ndiaye',
                'siret' => '12345678901234',
                'fleet_size' => 15,
                'email_verified_at' => now(),
            ]
        );
        if (!$owner->hasRole('equipment_owner')) {
            $owner->assignRole('equipment_owner');
        }

        // Create or retrieve a reference producer (renter)
        $producer = User::firstOrCreate(
            ['email' => 'producer@agri-platform.com'],
            [
                'name' => 'Fatou Sow',
                'password' => bcrypt('producer123'),
                'phone' => '+221 77 345 67 89',
                'address_line1' => 'Saint-Louis, Sénégal',
                'farm_name' => 'Ferme Bio Sow',
                'farm_type' => 'Agriculture biologique',
                'email_verified_at' => now(),
            ]
        );
        if (!$producer->hasRole('producer')) {
            $producer->assignRole('producer');
        }

        // Ensure a set of equipment categories exists
        $equipmentCategories = [
            'travail-du-sol' => 'Travail du Sol',
            'semis-plantation' => 'Semis & Plantation',
            'entretien-desherbage' => 'Entretien & Désherbage',
            'irrigation' => 'Irrigation',
            'recolte' => 'Récolte',
            'logistique-transport' => 'Logistique & Transport',
        ];

        $categories = collect($equipmentCategories)->mapWithKeys(function ($name, $slug) {
            $category = Category::firstOrCreate(
                ['slug' => $slug, 'type' => 'equipment'],
                ['name' => $name, 'type' => 'equipment']
            );
            return [$slug => $category->id];
        });

        $samples = [
            [
                'title' => 'Tracteur (70 CV)',
                'description' => 'Force motrice idéale pour le labour, le transport et le remorquage d\'outils agricoles.',
                'daily_rate' => 75000,
                'location' => 'Thiès, Sénégal',
                'category_slug' => 'travail-du-sol',
            ],
            [
                'title' => 'Charrue à disques',
                'description' => 'Outil indispensable pour retourner le sol et préparer le lit de semence.',
                'daily_rate' => 20000,
                'location' => 'Kaolack, Sénégal',
                'category_slug' => 'travail-du-sol',
            ],
            [
                'title' => 'Semoir de précision',
                'description' => 'Permet un semis homogène et précis pour le maïs, le mil ou l\'arachide.',
                'daily_rate' => 25000,
                'location' => 'Louga, Sénégal',
                'category_slug' => 'semis-plantation',
            ],
            [
                'title' => 'Pulvérisateur automoteur',
                'description' => 'Traitement phytosanitaire rapide et efficace avec une large rampe.',
                'daily_rate' => 28000,
                'location' => 'Dakar, Sénégal',
                'category_slug' => 'entretien-desherbage',
            ],
            [
                'title' => 'Motopompe diesel',
                'description' => 'Pompage puissant pour l\'irrigation, adaptée aux grandes exploitations.',
                'daily_rate' => 18000,
                'location' => 'Tambacounda, Sénégal',
                'category_slug' => 'irrigation',
            ],
            [
                'title' => 'Moissonneuse-batteuse',
                'description' => 'Récolte et battage en un seul passage, idéale pour le riz ou le maïs.',
                'daily_rate' => 125000,
                'location' => 'Saint-Louis, Sénégal',
                'category_slug' => 'recolte',
            ],
            [
                'title' => 'Remorque agricole',
                'description' => 'Transport polyvalent pour les récoltes ou intrants agricoles.',
                'daily_rate' => 16000,
                'location' => 'Fatick, Sénégal',
                'category_slug' => 'logistique-transport',
            ],
        ];

        foreach ($samples as $data) {
            Equipment::firstOrCreate(
                [
                    'user_id' => $owner->id,
                    'title' => $data['title'],
                ],
                [
                    'category_id' => $categories[$data['category_slug']] ?? null,
                    'description' => $data['description'],
                    'daily_rate' => $data['daily_rate'],
                    'location' => $data['location'],
                    'pricing_unit' => 'per_day',
                    'is_available' => true,
                    'is_active' => true,
                ]
            );
        }

        $this->command->info('✅ Échantillon de matériels agricoles prêt pour la location.');
        $this->command->info('✅ Comptes de référence : producer@agri-platform.com / owner@agri-platform.com');
    }
}

