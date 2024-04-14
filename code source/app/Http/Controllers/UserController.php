<?php

namespace App\Http\Controllers;

use App\Mail\UserDeletedNotification;
use App\Models\Formation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Affiche une liste de tout les utilisateurs.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(string $id)
    {
        $formations = Formation::all();
        $user = User::find($id);
        if(!$user){
            return redirect()->route('AdminMain')->with('error', 'l\utilisateur n\a pas été trouvé');
        }
        return view('admin.userEdit', ['user'=>$user, 'formations'=>$formations]);
    }

    /**
     * Met à jour l'utilisateur spécifié.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = User::where('id','=',$request->input('user_id'))->firstOrFail();
        if(!$user){
            return redirect()->back()->with('error', 'l\'utilisateur n\'as pas été trouvé en base');
        }

        $user->name = $request->input('name');
        $user->first_name = $request->input('first_name');
        $user->email = $request->input('email');
        $user->formation_id = $request->input('formation_id');

        if(!$user->save()){
            return redirect()->back()->with('error', 'l\'utilisateur n\'as pas été modifié');
        }
        return redirect()->route('editUser', ['id'=>$user->id])->with('success', 'la modification à bien été faite');
    }

    /**
     * supprime l'utilisateur specifié en base.
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        $user = User::findOrFail($id);
        if(!$user){
            return redirect()->back()->with('error', 'impossible de trouvé l\'utilisateur en base');
        }
        if(!$this->fixJohnDoeToUserItem($user->id)){
            return redirect()->back()->with('error', 'impossible de rediriger les ressources de l\'utilisateur');
        }
        if(!$user->delete()){
            return redirect()->back()->with('error', 'impossible de supprimer l\'utilisateur');
        }
        // Envoyer l'e-mail de notification
        Mail::to($user->email)->send(new UserDeletedNotification());

        return redirect()->route('AdminMain')->with('succes', 'l\'utilisateur a bien été supprimé');
    }


    /**
     * gere toutes les contrainte de la table User en mettant l'utilisateur JohnDoe par defaut
     * @param int $userId
     * @return bool
     */
    private function fixJohnDoeToUserItem(int $userId){
        $johnUser = new User;
        $johnUser = $johnUser->getJohn();
        if(!$johnUser){
            return False;
        }
        //modification des post du user
        $forumPostController = new ForumPostController();
        if(!$forumPostController->fixJohnToForumPostUser($userId, $johnUser->id)) {
            return false;
        }

        //modification des reponse du user
        $forumReponsePostController = new ForumResponseController();
        if(!$forumReponsePostController->fixJohnToForumResponsePostUser($userId, $johnUser->id)) {
            return false;
        }

        //modification des ressources du user
        $ressourcesController = new RessourcePostController();
        if(!$ressourcesController->fixJohnToResssource($userId, $johnUser->id)) {
            return false;
        }

        return True;
    }
}
