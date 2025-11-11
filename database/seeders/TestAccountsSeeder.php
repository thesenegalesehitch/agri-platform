<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class TestAccountsSeeder extends Seeder
{
    /**
     * Créer des comptes de test pour tous les profils
     */
    public function run(): void
    {
        $this->command->info('🌱 Création des comptes de test...');

        // Assurer que tous les rôles existent
        $roles = ['admin', 'producer', 'equipment_owner'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin Test',
                'password' => bcrypt('admin123'),
                'phone' => '+221 77 000 00 01',
                'phone_verified' => true,
                'region' => 'Dakar',
                'ville' => 'Dakar',
                'address_line1' => 'Dakar, Sénégal',
                'country' => 'Sénégal',
                'cni_verified' => true,
                'cni_verified_at' => now(),
                'is_suspended' => false,
                'email_verified_at' => now(),
            ]
        );
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
        $this->command->info('✅ Admin créé : admin@test.com / admin123');

        // Producteur (Producer)
        $producer = User::updateOrCreate(
            ['email' => 'producer@test.com'],
            [
                'name' => 'Producteur Test',
                'password' => bcrypt('producer123'),
                'phone' => '+221 77 000 00 03',
                'phone_verified' => true,
                'region' => 'Saint-Louis',
                'ville' => 'Saint-Louis',
                'address_line1' => 'Saint-Louis, Sénégal',
                'country' => 'Sénégal',
                'farm_name' => 'Ferme Bio Test',
                'farm_type' => 'Agriculture biologique',
                'cni_verified' => true,
                'cni_verified_at' => now(),
                'is_suspended' => false,
                'email_verified_at' => now(),
            ]
        );
        if (!$producer->hasRole('producer')) {
            $producer->assignRole('producer');
        }
        $this->command->info('✅ Producteur créé : producer@test.com / producer123');

        // Propriétaire de Matériel (Equipment Owner)
        $equipmentOwner = User::updateOrCreate(
            ['email' => 'owner@test.com'],
            [
                'name' => 'Propriétaire Matériel Test',
                'password' => bcrypt('owner123'),
                'phone' => '+221 77 000 00 04',
                'phone_verified' => true,
                'region' => 'Kaolack',
                'ville' => 'Kaolack',
                'address_line1' => 'Kaolack, Sénégal',
                'country' => 'Sénégal',
                'company_name' => 'Agri-Equip Test',
                'siret' => '12345678901234',
                'fleet_size' => 10,
                'cni_verified' => true,
                'cni_verified_at' => now(),
                'is_suspended' => false,
                'email_verified_at' => now(),
            ]
        );
        if (!$equipmentOwner->hasRole('equipment_owner')) {
            $equipmentOwner->assignRole('equipment_owner');
        }
        $this->command->info('✅ Propriétaire matériel créé : owner@test.com / owner123');

        // Comptes supplémentaires pour plus de flexibilité
        // Producteur 2
        $producer2 = User::updateOrCreate(
            ['email' => 'producteur@test.com'],
            [
                'name' => 'Producteur 2 Test',
                'password' => bcrypt('producteur123'),
                'phone' => '+221 77 000 00 06',
                'phone_verified' => true,
                'region' => 'Louga',
                'ville' => 'Louga',
                'address_line1' => 'Louga, Sénégal',
                'country' => 'Sénégal',
                'farm_name' => 'Ferme Test 2',
                'farm_type' => 'Agriculture conventionnelle',
                'cni_verified' => true,
                'cni_verified_at' => now(),
                'is_suspended' => false,
                'email_verified_at' => now(),
            ]
        );
        if (!$producer2->hasRole('producer')) {
            $producer2->assignRole('producer');
        }
        $this->command->info('✅ Producteur 2 créé : producteur@test.com / producteur123');

        // Propriétaire Matériel 2
        $owner2 = User::updateOrCreate(
            ['email' => 'proprietaire@test.com'],
            [
                'name' => 'Propriétaire Matériel 2 Test',
                'password' => bcrypt('proprietaire123'),
                'phone' => '+221 77 000 00 07',
                'phone_verified' => true,
                'region' => 'Tambacounda',
                'ville' => 'Tambacounda',
                'address_line1' => 'Tambacounda, Sénégal',
                'country' => 'Sénégal',
                'company_name' => 'Matériel Agricole Test',
                'siret' => '98765432109876',
                'fleet_size' => 8,
                'cni_verified' => true,
                'cni_verified_at' => now(),
                'is_suspended' => false,
                'email_verified_at' => now(),
            ]
        );
        if (!$owner2->hasRole('equipment_owner')) {
            $owner2->assignRole('equipment_owner');
        }
        $this->command->info('✅ Propriétaire matériel 2 créé : proprietaire@test.com / proprietaire123');

        $this->command->info('');
        $this->command->info('═══════════════════════════════════════════════════════');
        $this->command->info('📋 RÉSUMÉ DES COMPTES DE TEST');
        $this->command->info('═══════════════════════════════════════════════════════');
        $this->command->info('');
        $this->command->info('👤 ADMIN');
        $this->command->info('   Email: admin@test.com');
        $this->command->info('   Mot de passe: admin123');
        $this->command->info('');
        $this->command->info('🌾 PRODUCTEURS');
        $this->command->info('   Email: producer@test.com → Mot de passe: producer123');
        $this->command->info('   Email: producteur@test.com → Mot de passe: producteur123');
        $this->command->info('');
        $this->command->info('🚜 PROPRIÉTAIRES DE MATÉRIEL');
        $this->command->info('   Email: owner@test.com → Mot de passe: owner123');
        $this->command->info('   Email: proprietaire@test.com → Mot de passe: proprietaire123');
        $this->command->info('');
        $this->command->info('═══════════════════════════════════════════════════════');
        $this->command->info('');
    }
}

