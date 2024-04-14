<?php

namespace Database\Factories;

use App\Models\ForumPost;
use App\Models\ForumResponse;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ForumResponse>
 */
class ForumResponseFactory extends Factory
{
    /**
     * Définit l'état par défaut du modèle.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $userId = User::pluck('id')->random();
        $forum_post_id = ForumPost::pluck('id')->random();

        return [
            'content' => $this->faker->sentence(rand(50, 100)),
            'user_id' => $userId,
            'forum_post_id' =>$forum_post_id
        ];
    }
}
