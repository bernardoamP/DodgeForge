<?php

namespace Database\Seeders;

use App\Models\Formation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create();
        $this->createAdmin();
        $this->createJohnDoe();
    }

    /**
     * Crée un utilisateur administrateur s'il n'existe pas déjà.
     */
    private function createAdmin(){
                //creation de l'admin
                $existingAdmin = User::where('email', 'admin@admin.com')->first();
                if (!$existingAdmin) {
                //creation de l'admin
                $adminLabel = 'administrateur';
                $adminId = Role::where('label', $adminLabel)->first()->id;

                $formationLabel = 'PROFESSIONEL';
                $formationId = Formation::where('label', $formationLabel)->first()->id;

                User::create([
                    'name' => 'Administrateur',
                    'first_name' => 'Administrateur',
                    'email' => 'admin@admin.com',
                    'password' => Hash::make('@dodgeBoss1'),
                    'formation_id' => $formationId,
                    'role_id' => $adminId,
                    ]);
                }
    }

    /**
     * Crée l'utilisateur John Doe s'il n'existe pas déjà.
     */
    private function createJohnDoe(){
        $existingJohn = User::where('email', 'john@doe.com')->first();
        if (!$existingJohn) {

        $formationLabel = 'PASSIONNE';//formation crée en Seeder de Formation
        $formationId = Formation::where('label', $formationLabel)->first()->id;

        $roleLabel = 'utilisateur';
        $role_id = Role::where('label',$roleLabel)->first()->id;

        User::create([
            'name' => 'Doe',
            'first_name' => 'John',
            'email' => 'john@doe.com',
            'password' => Hash::make('2345@!johndoe!@6789'),
            'formation_id' => $formationId,
            'role_id' => $role_id,
            ]);
        }
    }

}
