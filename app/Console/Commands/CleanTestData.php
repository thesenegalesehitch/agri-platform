<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Equipment;
use App\Models\Rental;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CleanTestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:test-data {--force : Supprimer sans confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Supprime toutes les données de test (utilisateurs, équipements, locations)';

    /**
     * Liste des emails de test à supprimer (ou patterns)
     */
    protected $testEmails = [
        'admin@test.com',
        'buyer@test.com',
        'producer@test.com',
        'equipment@test.com',
        'owner@test.com',
        'acheteur@test.com',
        'producteur@test.com',
        'proprietaire@test.com',
        'buyer@agri-platform.com',
        'producer@agri-platform.com',
        'owner@agri-platform.com',
        'producer-test@agri-platform.com',
        'owner-test@agri-platform.com',
    ];

    /**
     * Patterns d'emails de test à supprimer
     */
    protected $testEmailPatterns = [
        '%@test.com',
        '%test%@agri-platform.com',
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->option('force')) {
            if (!$this->confirm('⚠️  ATTENTION: Cette action va supprimer TOUTES les données de test. Êtes-vous sûr ?')) {
                $this->info('Opération annulée.');
                return 0;
            }
        }

        $this->info('🗑️  Suppression des données de test...');
        $this->newLine();

        DB::beginTransaction();
        try {
            // Récupérer tous les utilisateurs de test
            $testUsersQuery = User::whereIn('email', $this->testEmails);
            
            // Ajouter les utilisateurs avec des patterns d'email de test
            foreach ($this->testEmailPatterns as $pattern) {
                $testUsersQuery->orWhere('email', 'like', $pattern);
            }
            
            $testUsers = $testUsersQuery->get();
            
            // Exclure les admins réels (garder nleopold931@gmail.com et alexandrendour7@gmail.com)
            $testUsers = $testUsers->filter(function ($user) {
                $realAdmins = ['nleopold931@gmail.com', 'alexandrendour7@gmail.com'];
                return !in_array($user->email, $realAdmins);
            });
            
            if ($testUsers->isEmpty()) {
                $this->warn('Aucun utilisateur de test trouvé.');
                return 0;
            }

            $this->info("📋 {$testUsers->count()} utilisateur(s) de test trouvé(s)");

            // Supprimer les équipements de test
            $testEquipmentIds = Equipment::whereIn('user_id', $testUsers->pluck('id'))->pluck('id');
            if ($testEquipmentIds->isNotEmpty()) {
                // Supprimer les images des équipements
                $equipmentImages = Image::where('imageable_type', Equipment::class)
                    ->whereIn('imageable_id', $testEquipmentIds)
                    ->get();
                
                foreach ($equipmentImages as $image) {
                    if (Storage::exists($image->path)) {
                        Storage::delete($image->path);
                    }
                    $image->delete();
                }
                
                // Supprimer les locations liées
                Rental::whereIn('equipment_id', $testEquipmentIds)->delete();
                
                // Supprimer les équipements
                Equipment::whereIn('id', $testEquipmentIds)->delete();
                $this->info("✅ {$testEquipmentIds->count()} équipement(s) supprimé(s)");
            }

            // Supprimer les locations de test
            $testRentalIds = Rental::whereIn('renter_id', $testUsers->pluck('id'))->pluck('id');
            if ($testRentalIds->isNotEmpty()) {
                Rental::whereIn('id', $testRentalIds)->delete();
                $this->info("✅ {$testRentalIds->count()} location(s) supprimée(s)");
            }

            // Supprimer les notifications
            DB::table('notifications')
                ->whereIn('notifiable_id', $testUsers->pluck('id'))
                ->delete();

            // Supprimer les relations de rôles
            foreach ($testUsers as $user) {
                $user->roles()->detach();
            }

            // Supprimer les utilisateurs de test
            $deletedCount = $testUsers->count();
            $testUserIds = $testUsers->pluck('id');
            
            // Construire la requête de suppression
            $deleteQuery = User::whereIn('email', $this->testEmails);
            foreach ($this->testEmailPatterns as $pattern) {
                $deleteQuery->orWhere('email', 'like', $pattern);
            }
            $deleteQuery->whereNotIn('email', ['nleopold931@gmail.com', 'alexandrendour7@gmail.com'])->delete();
            
            $this->info("✅ {$deletedCount} utilisateur(s) supprimé(s)");
            $this->newLine();

            // Nettoyer les catégories orphelines (optionnel)
            // On ne les supprime pas car elles pourraient être utilisées plus tard

            DB::commit();
            
            $this->info('✨ Nettoyage terminé avec succès !');
            return 0;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('❌ Erreur lors du nettoyage : ' . $e->getMessage());
            return 1;
        }
    }
}
