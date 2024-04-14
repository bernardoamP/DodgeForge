<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Ressources;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Exécute les opérations de remplissage de la base de données.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(FormationSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ThemeSeeder::class);
        $this->call(ForumPostSeeder::class);
        $this->call(ForumResponseSeeder::class);
        $this->call(RessourcePostSeeder::class);
    }
}
