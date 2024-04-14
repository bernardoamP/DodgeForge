<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Formation;
use App\Models\ForumPost;
use App\Models\ForumResponse;
use App\Models\Role;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AdminRoleTest extends TestCase
{
    use RefreshDatabase;

    private $admin =[
        'email' => 'admin@admin.com',
        'password' => '@dodgeBoss1',
    ];

    /**
     * Test si un utilisateur admin à été créér au seed.
     */
    public function test_there_is_an_admin_user(){
        $roleAdmin = Role::where('label', 'administrateur')->first();
        $admin = User::where('role_id', $roleAdmin->id)->first();
        $this->assertNotNull($admin);
    }

    /**
     * test si l'admin peut se connecter en tant qu'admin
     */
    public function test_admin_can_be_login_as_admin(){
        $RoleAdmin = Role::where('label', 'administrateur')->first();
        $response = $this->post(route('loggin'), [
            'email' => $this->admin['email'],
            'password' => $this->admin['password'],
        ]);

        $this->assertTrue(Auth::check());
        $this->assertEquals($RoleAdmin->id, Auth::user()->role_id);
        $this->assertTrue(Auth::user()->isAdmin());
    }

    /**
     * test si un admin a acces a la fiche d'un post
     */
    public function test_admin_can_manage_a_postForum(){

        $this->post(route('loggin'), [
            'email' => $this->admin['email'],
            'password' => $this->admin['password'],
        ]);
        $post = ForumPost::factory()->create();
        $response = $this->post(route('forumIndex'));
        $response->assertSee(route('showForumPost', ['id' => $post->id]));
        $response = $this->get(route('showForumPost', ['id' => $post->id]));
        $response->assertViewIs('admin.forumPostEdit');
    }

    /**
     * test un non admin ne peut pas avoir acces a la fiche d'un post
     */
    public function test_a_not_admin_can_not_manage_a_postForum(){

        $user = User::factory()->create();
        $this->post(route('loggin'), [
            'email' => $user->email,
            'password' => $user->password,
        ]);

        $post = ForumPost::factory()->create();
        $response = $this->post(route('forumIndex'));
        $response->assertDontSee(route('showForumPost', ['id' => $post->id]));
    }

    /**
     * test un admin peut mettre a jour un theme de post
     */
    public function test_admin_can_update_post_theme(){

        $this->post(route('loggin'), [
            'email' => $this->admin['email'],
            'password' => $this->admin['password'],
        ]);
        $themeId = Theme::pluck('id')->random();
        $post = ForumPost::factory()->create();

        $response = $this->post(route('updateForumPost'), [
            'post_id' => $post->id,
            'theme_id' => $themeId,
        ]);

        $response->assertRedirect();
        $updatedPost = ForumPost::find($post->id);
        $this->assertEquals($themeId, $updatedPost->theme_id);
    }

    /**
     * test un admin peut mettre a jour une categorie et un theme sur un post
     */
    public function test_admin_can_update_post_category_and_theme(){

        $this->post(route('loggin'), [
            'email' => $this->admin['email'],
            'password' => $this->admin['password'],
        ]);

        $category = Category::inRandomOrder()->first();
        $theme = $category->themes()->inRandomOrder()->first();

        $post = ForumPost::factory()->create();

        $response = $this->post(route('updateForumPost'), [
            'post_id' => $post->id,
            'theme_id' => $theme->id,
        ]);

        $response->assertRedirect();

        $updatedPost = ForumPost::find($post->id);

        $this->assertEquals($theme->id, $updatedPost->theme->id);
        $this->assertEquals($category->id, $updatedPost->theme->category->id);
    }

    /**
     * test un admin peut supprimer un post
     */
    public function test_admin_can_delete_a_post(){

        $this->post(route('loggin'), [
            'email' => $this->admin['email'],
            'password' => $this->admin['password'],
        ]);
        $post = ForumPost::factory()->create();

        $this->assertDatabaseHas('forum_posts', ['id' => $post->id]);
        $response = $this->delete(route('deleteForumPost', ['id' => $post->id]));
        $response->assertRedirect();
        $this->assertDatabaseMissing('forum_posts', ['id' => $post->id]);
        }

    /**
     * test un non admin ne peut pas supprimer un post
     */
    public function test_a_not_admin_can_not_delete_a_post(){

        $user = User::factory()->create();

        $this->post(route('loggin'), [
            'email' => $user->email,
            'password' => $user->password,
        ]);
        $post = ForumPost::factory()->create();

        $this->assertDatabaseHas('forum_posts', ['id' => $post->id]);
        $response = $this->delete(route('deleteForumPost', ['id' => $post->id]));
        $this->assertDatabaseHas('forum_posts', ['id' => $post->id]);
        }

    /**
     * test un admin peut supprimer une reponse a un post
     */
    public function test_admin_can_delete_a_postResponse(){

        $this->post(route('loggin'), [
            'email' => $this->admin['email'],
            'password' => $this->admin['password'],
        ]);
        $postResponse = ForumResponse::factory()->create();

        $this->assertDatabaseHas('forum_responses', ['id' => $postResponse->id]);
        $response = $this->delete(route('deletePostResponse', ['id' => $postResponse->id]));
        $response->assertRedirect();
        $this->assertDatabaseMissing('forum_responses', ['id' => $postResponse->id]);
        }

    /**
     * test un non admin ne peut pas supprimer un post
     */
    public function test_a_not_admin_can_not_delete_a_postResponse(){

        $user = User::factory()->create();

        $this->post(route('loggin'), [
            'email' => $user->email,
            'password' => $user->password,
        ]);
        $postResponse = ForumResponse::factory()->create();

        $this->assertDatabaseHas('forum_responses', ['id' => $postResponse->id]);
        $response = $this->delete(route('deletePostResponse', ['id' => $postResponse->id]));
        $this->assertDatabaseHas('forum_responses', ['id' => $postResponse->id]);
        }

    /**
     * l'admin a acces a une page d'administration
     */
    public function an_admin_have_admin_interface(){
        $this->post(route('loggin'), [
            'email' => $this->admin['email'],
            'password' => $this->admin['password'],
        ]);

        $response = $this->get(route('AdminMain'));
        $response->assertViewIs('admin.main');
        $response->assertViewHas('users');
        $response->assertViewHas('formations');
        $response->assertViewHas('categories');
    }

    /**
     * l'administrateur peut ajouter une categorie
     */
    public function test_an_admin_can_store_a_new_categorie(){
        $this->post(route('loggin'), [
            'email' => $this->admin['email'],
            'password' => $this->admin['password'],
        ]);
        $category = ['label' => 'newCategorie'];
        $response = $this->post(route('storeCategory', $category));
        $response->assertRedirect(route('AdminMain'));
        $this->assertDatabaseHas('categories', ['label' => $category['label']]);

    }

     /**
     * l'administrateur peut ajouter un theme
     */
    public function test_an_admin_can_store_a_new_theme(){
        $this->post(route('loggin'), [
            'email' => $this->admin['email'],
            'password' => $this->admin['password'],
        ]);
        $category = Category::inRandomOrder()->first(["id"]);
        $theme = [
            'label' => 'newTheme',
            'category_id' => $category->id
        ];
        $response = $this->post(route('storeTheme', $theme));
        $response->assertRedirect(route('AdminMain'));
        $this->assertDatabaseHas('themes', ['label' => $theme['label']]);
    }

     /**
     * l'administrateur peut ajouter une formation
     */
    public function test_an_admin_can_store_a_new_formation(){
        $this->post(route('loggin'), [
            'email' => $this->admin['email'],
            'password' => $this->admin['password'],
        ]);
        $formation = [
            'label' => 'newFormation',
        ];
        $response = $this->post(route('storeFormation', $formation));
        $response->assertRedirect(route('AdminMain'));
        $this->assertDatabaseHas('formations', ['label' => $formation['label']]);
    }

     /**
     * l'administrateur peut avoir acces a une fiche utilisateur
     */
        public function test_admin_has_access_to_user_profile() {
            $user = User::inRandomOrder()->first(["id"]);
            $this->post(route('loggin'), [
                'email' => $this->admin['email'],
                'password' => $this->admin['password'],
            ]);
            $response = $this->get(route("editUser", ["id" => $user->id]));
            $response->assertViewIs('admin.userEdit');
            $response->assertViewHas('user');
            $response->assertViewHas('formations');
        }


     /**
     * l'administrateur peut modifier un utilisateur
     */
    public function test_admin_can_update_a_user() {
        $user = User::factory()->create();
        $this->post(route('loggin'), [
            'email' => $this->admin['email'],
            'password' => $this->admin['password'],
        ]);
        $formation = Formation::inRandomOrder()-> first(["id"]);
        $user->formation_id = $formation->id;
        $userRequest = [
            'name' => $user->name,
            'first_name' => $user->first_name,
            'email' => $user->email,
            'user_id' => $user->id,
            'formation_id' => $formation->id
        ];
        $response = $this->post(route('updateUser', $userRequest));
        $response->assertRedirect()->with('success');
        $updatesUser = User::find($user->id);
        $this->assertEquals($updatesUser->formation_id, $formation->id);
    }

     /**
     * l'administrateur peut supprimer un utilisateur, avec notification
     */
    public function test_admin_can_delete_a_user() {
        $user = User::factory()->create();
        $this->post(route('loggin'), [
            'email' => $this->admin['email'],
            'password' => $this->admin['password'],
        ]);
        $response = $this->delete(route('deleteUser', ['id'=>$user->id]));
        $response->assertRedirect();
        $this->assertDatabaseMissing('users', ['id', $user->id]);
    }

}





