<?php

namespace Database\Factories;

use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ForumPost>
 */
class ForumPostFactory extends Factory
{
    /**
     * Définit l'état par défaut du modèle.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = User::pluck('id')->random();
        $themeId = Theme::pluck('id')->random();

        return [
            'title' => $this->faker->sentence(rand(5, 10)),
            'content' => $this->faker->sentence(rand(50, 200)),
            'theme_id' => $themeId,
            'user_id' => $userId,
        ];
    }
}
