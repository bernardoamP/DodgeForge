<?php

namespace Tests\Feature\Auth;

use App\Mail\PasswordCode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test la presence d'une page pour reinitialiser le mot de passe
     */
    public function test_reset_password_link_screen_can_be_rendered(): void
    {
        $response = $this->get(route('forgotPassword'));
        $response->assertStatus(200);
    }

    /**
     * Test si un mail est envoyé avec le code de reinitialisation du mot de passe,
     *  et si le code est stocké en cache
     */
    public function test_reset_password_link_can_be_requested(): void
    {
        Mail::fake();
        $user = User::factory()->create();
        $this->post(route('passwordforgotCode', ['email' => $user->email]));
        $resetCode = Cache::get('reset_code_' . $user->email);
        $this->assertNotNull($resetCode);
        Mail::assertSent(PasswordCode::class, function ($mail) use ($user, $resetCode) {
            return $mail->hasTo($user->email) && $mail->code === $resetCode;
        });
    }

    /**
     * Test si un mauvais email est envoyé dans le formulaire, on est redirigé sur le formulaire avec une erreur
     */
    public function test_forgot_password_get_code_validation_fails_for_not_exists_email(): void
{
    $invalidEmail = 'patate@patate';

    $response = $this->post(route('passwordforgotCode'), ['email' => $invalidEmail]);
    $response->assertStatus(302)->assertSessionHasErrors(['email']);
}

    /**
     * Test si une page pour renseigner le code de reinitialisation du mot de passe est disponible
     */
    public function test_reset_code_confirmation_screen_can_be_rendered(): void
    {

        $user = User::factory()->create();
        $response = $this->post(route('passwordforgotCode',['email' => $user->email]));
        $response->assertRedirectToRoute('viewPasswordForgotCode', ['email' => $user->email]);
        $viewResponse = $this->get(route('viewPasswordForgotCode', ['email' => $user->email]));
        $viewResponse->assertViewIs('auth.forgotPasswordCode')
                    ->assertViewHas('email',$user->email);
    }

    /**
     * Test un mauvais code ne peut pas permettre d'acceder a la page de reinitialisation du formulaire
     */
    public function test_forgot_password_with_invalid_code_return_codeForm_with_error(): void
    {
        $email = User::pluck('email')->random();
        $invalidCode = 'invalid_code';
                $response = $this->post(route('authenticateCode', [
            'email' => $email,
            'code' => $invalidCode]));
                  $response->assertViewIs('auth.forgotPasswordCode');
        $response->assertViewHas('email', $email);
        $response->assertViewHas('error', 'Code incorrect ou expiré. Veuillez réessayer.');

    }

    /**
     * Avec le bon code on est redirigé vers un formulaire pour reinitialisé le mot de passe,
     * le mail est passé comme moyen de recherche de l'utilisateur
     */
    public function test_a_reset_password_screen_can_be_rendered_with_valid_code(): void
    {
$user = User::factory()->create();
        $this->post(route('passwordforgotCode', ['email' => $user->email]));
        $valideCode = Cache::get('reset_code_' . $user->email);
        $response = $this->post(route('authenticateCode', [
            'email' => $user->email,
            'code' => $valideCode]));
        $response->assertRedirectToRoute('viewResetPassword', ['user' => $user]);
        $viewResponse = $this->get(route('viewResetPassword', ['user' => $user]));
        $viewResponse->assertViewIs('auth.resetPassword')
                    ->assertViewHas('user', $user);
    }

    /**
     * le mot de passe doit etre confirmé
     */
    public function test_the_reset_password_can_not_be_stored_without_a_password_confirmation()
    {
    $user = User::factory()->create();
    $this->post(route('StoreResetPassword', [
        'user' => $user,
        'password' => '@newPassword1',
        'password_confirmation' => '@newPassword2',
    ]));
    $this->assertDatabaseMissing('users', [
        'id' => $user->id,
        'password' => Hash::make('@newPassword1'),
    ]);
    }

    /**
     * le mot de passe doit etre solide pour etre stocké en base de donnée
     */
    public function test_the_reset_password_can_not_be_stored_without_a_strong_password()
    {
    $user = User::factory()->create();
    $this->post(route('StoreResetPassword', [
        'user' => $user,
        'password' => 'Password',
        'password_confirmation' => 'Password',
    ]));
    $this->assertDatabaseMissing('users', [
        'id' => $user->id,
        'password' => Hash::make('Password'),
    ]);
    }

    /**
     * l'email est bien mis a jours pour le bon User
     */
    public function test_the_reset_password_is_store_for_the_good_user()
    {
        $user = User::factory()->create();
        $this->post(route('StoreResetPassword', [
            'user' => $user,
            'password' => '@newPassword1',
            'password_confirmation' => '@newPassword1',
        ]));
        $updatedUser = User::find($user->id);
        $this->assertTrue(Hash::check('@newPassword1', $updatedUser->password));
    }
}
