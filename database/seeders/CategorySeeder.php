<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Catégories de matériels par fonction
        $equipmentCategories = [
            'Travail du Sol',
            'Semis & Plantation',
            'Entretien & Désherbage',
            'Irrigation',
            'Récolte',
            'Logistique & Transport',
        ];
        
        foreach ($equipmentCategories as $name) {
            Category::firstOrCreate([
                'slug' => str($name)->slug(),
                'type' => 'equipment',
            ], [
                'name' => $name,
                'type' => 'equipment',
            ]);
        }
    }
}
