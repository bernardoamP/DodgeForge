<?php

namespace Database\Seeders;

use App\Models\ForumPost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForumPostSeeder extends Seeder
{
    /**
     * Exécute les opérations de remplissage de la base de données.
     */
    public function run(): void
    {
            ForumPost::factory()->count(10)->create();
    }
}
