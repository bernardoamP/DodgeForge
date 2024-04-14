<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Theme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThemeSeeder extends Seeder
{
   /**
     * Exécute les opérations de remplissage de la base de données.
     */
    public function run(): void
    {
        $categoriesThemes = [
            'Developpement' => ['Langage', 'Framework', 'Mobile', 'Logiciel de Bureau', 'Web', 'Base de donnée',
                                 'Jeux', 'Intelligence artificielle', 'IoT', 'Architecture', 'Contenerisation'],
            'Reseau' => ['Concept fondamentaux', 'Protocole réseau', 'Securité réseau', 'Technologie emmergente',
                         'Administration Système', 'Cloud', 'Technologie sans fil', 'Architecture réseau', 'Container'],
            'Cybersecurité' => ['Securité application', 'Securité système', 'Analyse de vulnerabilité', 'Legislation',
                                'Cryptologie', 'IA', 'Ingenierie social', 'Bonne pratique de code']
        ];

        foreach ($categoriesThemes as $categoryLabel => $themes) {
            $category = Category::where('label', $categoryLabel)->first();

            if ($category) {
                foreach ($themes as $themeLabel) {
                    $existingTheme = Theme::where('label', $themeLabel)->where('category_id', $category->id)->first();

                    if (!$existingTheme) {
                        DB::table('themes')->insert([
                            'label' => $themeLabel,
                            'category_id' => $category->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }
}
