<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesAndTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'admin' => 'Administrateur - Accès complet à la plateforme',
            'buyer' => 'Acheteur - Peut acheter des produits agricoles',
            'producer' => 'Producteur - Peut vendre des produits agricoles',
            'equipment_owner' => 'Propriétaire d\'équipement - Peut louer des équipements agricoles',
        ];

        foreach ($roles as $roleName => $description) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Create sample users with detailed profiles
        $admin = User::firstOrCreate(
            ['email' => 'admin@agri-platform.com'],
            [
                'name' => 'Administrateur Principal',
                'password' => bcrypt('admin123'),
                'phone' => '+221 77 123 45 67',
                'address_line1' => 'Dakar, Sénégal',
                'billing_vat_number' => 'SN123456789'
            ]
        );
        $admin->assignRole('admin');

        $buyer = User::firstOrCreate(
            ['email' => 'buyer@agri-platform.com'],
            [
                'name' => 'Ahmed Diop',
                'password' => bcrypt('buyer123'),
                'phone' => '+221 77 234 56 78',
                'address_line1' => 'Thiès, Sénégal',
                'billing_vat_number' => 'SN987654321'
            ]
        );
        $buyer->assignRole('buyer');

        $producer = User::firstOrCreate(
            ['email' => 'producer@agri-platform.com'],
            [
                'name' => 'Fatou Sow',
                'password' => bcrypt('producer123'),
                'phone' => '+221 77 345 67 89',
                'address_line1' => 'Saint-Louis, Sénégal',
                'farm_name' => 'Ferme Bio Sow',
                'farm_type' => 'Agriculture biologique'
            ]
        );
        $producer->assignRole('producer');

        $owner = User::firstOrCreate(
            ['email' => 'owner@agri-platform.com'],
            [
                'name' => 'Mamadou Ndiaye',
                'password' => bcrypt('owner123'),
                'phone' => '+221 77 456 78 90',
                'address_line1' => 'Kaolack, Sénégal',
                'company_name' => 'Agri-Equip Ndiaye',
                'siret' => '12345678901234',
                'fleet_size' => 15
            ]
        );
        $owner->assignRole('equipment_owner');
    }
}
