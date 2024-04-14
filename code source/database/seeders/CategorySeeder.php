<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Exécute les opérations de remplissage de la base de données.
     */
    public function run(): void
    {
        {
            $categories = ['Developpement', 'Reseau', 'Cybersecurité'];

            foreach ($categories as $categorie) {
                $existingCategorie = Category::where('label', $categorie)->first();
                if (!$existingCategorie) {
                    DB::table('categories')->insert([
                        'label' => $categorie,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }
    }
}
