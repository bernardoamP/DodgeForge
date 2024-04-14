<?php

namespace Database\Seeders;

use App\Models\ForumResponse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForumResponseSeeder extends Seeder
{
    /**
     * Exécute les opérations de remplissage de la base de données.
     */
    public function run(): void
    {
        ForumResponse::factory()->count(60)->create();
    }
}
