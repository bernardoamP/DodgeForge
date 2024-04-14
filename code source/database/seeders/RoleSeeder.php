<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Exécute les opérations de remplissage de la base de données.
     */
    public function run(): void
    {
        $roles = ['utilisateur', 'administrateur'];

        foreach ($roles as $role) {
            $existingRole = Role::where('label', $role)->first();
            if (!$existingRole) {
                DB::table('roles')->insert([
                    'label' => $role,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
