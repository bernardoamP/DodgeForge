<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * une route envoie vers un formulaire de connection
     */
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get(route('loggin'));

        $response->assertStatus(200);
    }

    /**
     * un utilisateur est authentifié avec les bon identifiants
     */
    public function test_users_can_authenticate_using_the_login_screen(): void{
            $user = User::factory()->create([
                'password' => Hash::make('@password1'),
            ]);

            $response = $this->post(route('logUser'), [
                'email' => $user->email,
                'password' => '@password1',
            ]);

            $response->assertRedirect(route('acceuil'));
    }

    /**
     * une authentification reuusi renvoie vers la page d'accueil
     */
    public function test_authentification_redirect_on_accueil_screen(): void{
        $user = User::factory()->create([
            'password' => Hash::make('@password2'),
        ]);

        $response = $this->post(route('logUser'), [
            'email' => $user->email,
            'password' => '@password2',
        ]);

        $response->assertRedirect(route('acceuil'));
}

    /**
     * les mauvais identifiant ne permettent pas l'authentification
     */
    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('loggin'), [
            'email' => $user->email,
            'password' => '@wrong-password1',
        ]);
        $response->assertRedirect(route('loggin'))
        ->assertSessionHasErrors(['error']);

        $this->assertGuest();
    }

    /**
     * un utilisateur peut se deconnecter
     */
    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('logout'));

        $this->assertGuest();
        $response->assertRedirect(route('acceuil'));
    }
}
