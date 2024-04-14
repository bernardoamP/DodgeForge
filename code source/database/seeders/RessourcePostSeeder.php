<?php

namespace Database\Seeders;

use App\Models\RessourcePost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RessourcePostSeeder extends Seeder
{
    /**
     * Exécute les opérations de remplissage de la base de données.
     */
    public function run(): void
    {
        RessourcePost::factory()->count(10)->create();
    }
}
