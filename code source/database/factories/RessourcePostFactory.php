<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Theme;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ressources>
 */
class RessourcePostFactory extends Factory
{
    /**
     * Définit l'état par défaut du modèle.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Récupérez un ID d'utilisateur existant au hasard
        $userId = User::pluck('id')->random();
        $themeId = Theme::pluck('id')->random();

        return [
            'title' => $this->faker->sentence(rand(5, 10)),
            'description' => $this->faker->sentence(rand(50, 300)),
            'theme_id' => $themeId,
            'user_id' => $userId,
            'file_path'=>'file/ressourcetxt.txt',
        ];
    }
}
