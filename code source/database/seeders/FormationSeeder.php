<?php

namespace Database\Seeders;

use App\Models\Formation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormationSeeder extends Seeder
{
    /**
     * Exécute les opérations de remplissage de la base de données.
     */
    public function run(): void
    {
        $formations = [
            'BTS SIO SLAM', 'BTS SIO SISR', 'BACHELOR DEVELOPEUR WEB', 'BACHELOR CYBERSECURITE',
            'MBA CYBERSECURITE', 'MBA FULL STACK', 'PROFESSIONEL', 'PASSIONNE'
    ];

        foreach ($formations as $formation) {
            $existingFormation = Formation::where('label', $formation)->first();
            if (!$existingFormation) {
                DB::table('formations')->insert([
                    'label' => $formation,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
