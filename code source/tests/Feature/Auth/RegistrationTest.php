<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    private $userValideData = [
        'name' => 'JohnDoe',
        'first_name' => 'John',
        'email' => 'john@example.com',
        'password' => '@password1',
        'password_confirmation' => '@password1',
        'formation_id' => 1,
    ];

    /**
     * une vue est rendu par la route register
     */
    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get(route('register'));

        $response->assertViewIs('auth.register')
            ->assertViewHas('formations');
    }

    /**
     * les champs requis sont tous présent
     */
    public function test_register_view_contains_required_fields()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200)
                 ->assertSee('name')
                 ->assertSee('first_name')
                 ->assertSee('email')
                 ->assertSee('password')
                 ->assertSee('password_confirmation')
                 ->assertSee('formation_id');
    }

    /**
     * un nouvel utilisateur peut s'enregistrer et etre authentifié
     */
    public function test_new_users_can_register_and_authenticate(): void
    {
        $this->post(route('storeUser'), $this->userValideData);

        $this->assertDatabaseHas('users',[
            'email' => $this->userValideData['email']
            ]);
    }

    /**
     * le champs nom est sous validation
     */
    public function test_form_name_is_being_validation(){
        $userNotValideData = $this->userValideData;
        $userNotValideData['name'] = "";
        $response = $this->post(route('storeUser'), $userNotValideData);
        $response->assertStatus(302)->assertSessionHasErrors(['name']);
    }

    /**
     * le champs prenom est sous validation
     */
    public function test_form_first_name_is_being_validation(){
        $userNotValideData = $this->userValideData;
        $userNotValideData['first_name'] = "";
        $response = $this->post(route('storeUser'), $userNotValideData);
        $response->assertStatus(302)->assertSessionHasErrors(['first_name']);
    }

    /**
     * le champs password est sous validation
     */
    public function test_form_password_is_being_validation(){
        $userNotValideData = $this->userValideData;
        $userNotValideData['password'] = 'patate';
        $response = $this->post(route('storeUser'), $userNotValideData);
        $response->assertStatus(302)->assertSessionHasErrors(['password']);
    }

    /**
     * le champs password est sous confirmation
     */
    public function test_form_password_is_being_confirmed(){
        $userNotValideData = $this->userValideData;
        $userNotValideData['password_confirmation'] = '@password2';
        $response = $this->post(route('storeUser'), $userNotValideData);
        $response->assertStatus(302)->assertSessionHasErrors(['password']);
    }

    /**
     * le champs formation_id est sous validation
     */
    public function test_form_formation_id_is_being_validation(){
        $userNotValideData = $this->userValideData;
        $userNotValideData['formation_id'] = 0;
        $response = $this->post(route('storeUser'), $userNotValideData);
        $response->assertStatus(302)->assertSessionHasErrors(['formation_id']);
    }
}
