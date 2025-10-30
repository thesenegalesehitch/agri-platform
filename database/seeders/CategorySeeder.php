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
        $productCategories = ['Céréales', 'Fruits', 'Légumes', 'Semences', 'Engrais'];
        foreach ($productCategories as $name) {
            Category::firstOrCreate([
                'slug' => str($name)->slug(),
            ], [
                'name' => $name,
                'type' => 'product',
            ]);
        }

        $equipmentCategories = ['Tracteurs', 'Moissonneuses', 'Irrigation', 'Outils'];
        foreach ($equipmentCategories as $name) {
            Category::firstOrCreate([
                'slug' => str($name)->slug(),
            ], [
                'name' => $name,
                'type' => 'equipment',
            ]);
        }
    }
}
