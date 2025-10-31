<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create {--email=nleopold931@gmail.com} {--password=Alexandr3}';
    protected $description = 'Créer le compte administrateur';

    public function handle()
    {
        $email = $this->option('email');
        $password = $this->option('password');

        // Vérifier si la table roles existe
        try {
            \DB::table('roles')->count();
        } catch (\Exception $e) {
            $this->error('❌ Les tables de permissions n\'existent pas encore.');
            $this->info('Veuillez d\'abord exécuter :');
            $this->info('  1. php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"');
            $this->info('  2. php artisan migrate');
            return Command::FAILURE;
        }

        // Créer le rôle admin s'il n'existe pas
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Créer ou mettre à jour l'utilisateur admin
        $admin = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Administrateur Principal',
                'password' => bcrypt($password),
                'phone' => '+221 77 123 45 67',
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

        $this->info("✅ Compte admin créé avec succès !");
        $this->info("📧 Email: {$email}");
        $this->info("🔑 Mot de passe: {$password}");

        return Command::SUCCESS;
    }
}
