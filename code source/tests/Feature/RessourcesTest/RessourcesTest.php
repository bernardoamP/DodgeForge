<?php

namespace Tests\Feature\RessourcesTest;

use App\Models\RessourcePost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RessourcesTest extends TestCase
{
    use RefreshDatabase;

    //Tester une page qui affiche les ressources
    public function test_ressources_page(): void
    {
        $response = $this->get(route('ressource'));

        $response->assertStatus(200);
    }

    //Tester l'ajout d'une ressource
    public function test_ressources_can_be_stored(): void
    {
        $ressourcePost = [
            'title' => 'test',
            'description' => 'test',
            'theme_id' => '4',
            'user_id' => '4',
            'file_path'=>'file/ressourcetxt.txt'
        ];
        $ressource = RessourcePost::create($ressourcePost);

        $this->assertDatabaseHas('ressource_posts', $ressourcePost);
        $this->assertInstanceOf(RessourcePost::class, $ressource);
    }

    //Tester que si il y a au moins une ressource de creer, on l'affiche bien
    public function test_ressources_page_contains_created_ressource(): void
    {

        $user = User::factory()->create();
        $ressourcePost = RessourcePost::factory()->create([
            'user_id' => $user->id,
        ]);
        $this->actingAs($user);
        $response = $this->get(route('ressource'));
        $response->assertSeeText($ressourcePost->title);
    }

    public function test_login_screen_can_be_rendered_from_ressources_page(): void
    {
        $response = $this->get(route('loggin'));

        $response->assertStatus(200);
    }


    /**
     * Test si la page ressources contient le bouton "Télécharger" et qu'il redirige vers la bonne route
     *
     */
    public function test_user_can_download_ressources_and_be_redirected(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $ressourcePost = RessourcePost::factory()->create();
        $response = $this->get(route('downloadRessource', ['id' => $ressourcePost->id]));
        $response->assertStatus(200);
    }

    /**
     * Test si la page ressources contient le bouton "Télécharger" et qu'il redirige vers la bonne route
     *
     */
    public function test_gest_can_not_download_ressources_and_be_redirected(): void
    {
        $ressourcePost = RessourcePost::factory()->create();
        $response = $this->get(route('downloadRessource', ['id' => $ressourcePost->id]));
        $response->assertRedirect(route('loggin'));
    }
}
