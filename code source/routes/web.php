<?php

use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\ForumPostController;
use App\Http\Controllers\ForumResponseController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RessourcePostController;
use App\Http\Controllers\RessourceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//page d'acceuil
Route::get('/', function () {
    return view('accueil'); })->name('acceuil');

//page d'enregistrement d'un utilisateur
Route::get('/inscription', [AuthController::class, 'create'])->name('register');
//post le formulaire pour enregistrement d'un utilisateur
Route::post('/inscription', [AuthController::class, 'store'])->name('storeUser');
//page de connexion
Route::get('/connection', [AuthController::class, 'loggin'])->name('loggin');
//post le formulaire des identifiants
Route::post('/connection', [AuthController::class, 'logUser'])->name('logUser');
//deconnexion de l'utiisateur
Route::get('/accueil', [AuthController::class, 'logout'])->name('logout');
//renvoie la vue pour demander un code
Route::get('/passwordForget', [AuthController::class, 'viewForgotPassword'])->name('forgotPassword');
//renvoie la vue du formulaire pour valider le code
Route::get('/passwordForgetCode/{email}', [AuthController::class, 'viewforgotPasswordCode'])->name('viewPasswordForgotCode');
//renvoie la vue pour reinitialiser le mot de passe
Route::get('/resetPassword/{user}', [AuthController::class, 'viewResetPassword'])->name('viewResetPassword');
//page de consentement
Route::get('policy/consent', function () {
    return view('policy.consent'); })->name('consent');

//post le formulaire pour demander un code
Route::post('/passwordForget', [AuthController::class, 'forgotPasswordGetCode'])->name('passwordforgotCode');
//post le formulaire pour valider le code
Route::post('/passwordForgetCode', [AuthController::class, 'authenticateCode'])->name('authenticateCode');
//cherche le user en base et le charge
Route::get('/resetPassword/{email}', [AuthController::class, 'resetPasswordForm'])->name('resetPassword');
//enregistre la modification de mot de passe
Route::post('/resetPassword/{user}', [AuthController::class, 'StoreResetPassword'])->name('StoreResetPassword');

//page principale du forum
Route::get('forum', [ForumController::class, 'forumIndex'])->name('forumIndex');
//page du forum pour afficher les post avec un mot clé
Route::post('forum', [ForumController::class, 'forumPostByKeyWord'])->name('forumPostByKeyWord');

//groupe de route pour l'administrateur
Route::middleware(['auth', 'admin'])->group(function () {
    //route pour acceder a la page principale d'administration
    Route::get('/AdminMain', [AdminPageController::class, 'mainPage'])->name('AdminMain');
    //route admin, renvoie la vue pour gerer un ForumPost
    Route::get('admin/forumPost/{id}', [ForumPostController::class, 'show'])->name('showForumPost');
    //route admin, permet de supprimer un post
    Route::delete('admin/deleteForumPost/{id}', [ForumPostController::class, 'destroy'])->name('deleteForumPost');
    //route admin, permet de supprimer une reponse a un post
    Route::delete('admin/deletePostResponse/{id}', [ForumResponseController::class, 'destroy'])->name('deletePostResponse');
    //route admin, permet de mettre a jour une reponse a un post
    Route::post('admin/updatePostResponse', [ForumPostController::class, 'update'])->name('updateForumPost');
    //route admin, enregistre une nouvelle categorie
    Route::post('/storeCategory', [CategoryController::class, 'store'])->name('storeCategory');
    //route admin, enregistre un nouveau thème
    Route::post('/storeTheme', [ThemeController::class, 'store'])->name('storeTheme');
     //route admin, enregistre un nouveau thème
     Route::post('/storeFormation', [FormationController::class, 'store'])->name('storeFormation');
     //route admin, edit un utilisateur
     Route::get('/editUser/{id}', [UserController::class, 'edit'])->name('editUser');
     //route admin, update un utilisateur
     Route::post('/updateUser', [UserController::class, 'update'])->name('updateUser');
     //route admin, delete un utilisateur
     Route::delete('/deleteUser/{id}', [UserController::class, 'destroy'])->name('deleteUser');
    //route admin, permet de supprimer une ressource
     Route::delete('admin/deleteRessourcePost/{id}', [RessourcePostController::class, 'destroy'])->name('deleteRessourcePost');
    //route admin, permet de mettre a jour une ressource
     Route::delete('admin/updateRessourcePost', [RessourcePostController::class, 'update'])->name('updateRessourcePost');
    //route admin, renvoie la vue pour gerer un RessourcePost
     Route::get('admin/ressourcePost/{id}', [RessourcePostController::class, 'show'])->name('showRessourcePost');

});

//rend innacessible les route pour les utilisateur non authentifiés
Route::middleware('auth')->group(function () {
    //post le formulaire pour enregistrer un nouveau post
    Route::post('storeForumPost', [ForumPostController::class, 'storeForumPost'])->name('storeForumPost');
    //post le formulaire d'une reponse a un post
    Route::post('storeForumResponse', [ForumResponseController::class, 'storeForumResponse'])->name('storeForumResponse');
    //post le formulaire pour enregistrer une ressource
    Route::post('storeRessourcePost', [RessourcePostController::class, 'storeRessourcePost'])->name('storeRessourcePost');
    //Téléchargement de la ressource
    Route::get('downloadRessource/{id}', [RessourcePostController::class, 'downloadRessource'])->name('downloadRessource');
});

//page de forum avec les post d'un auteur
Route::get('forumPostByUsers/{id}', [ForumController::class, 'forumPostByUsers'])->name('forumPostByUsers');


Route::get('/ressource', [RessourceController::class, 'ressource'])->name('ressource');

Route::get('/ressourcePostByUsers/{id}', [RessourceController::class, 'ressourcePostByUsers'])->name('ressourcePostByUsers');

Route::post('/ressourcePostByKeyWord', [RessourceController::class, 'ressourcePostByKeyWord'])->name('ressourcePostByKeyWord');
