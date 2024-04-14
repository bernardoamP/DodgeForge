<?php

namespace App\Http\Controllers;

use App\Models\ForumResponse;
use App\Models\User;
use App\Http\Requests\ForumResponseRequest;
use Illuminate\Support\Facades\Auth;

class ForumResponseController extends Controller
{
    /**
     * Enregistre une nouvelle ressource dans le stockage.
     *
     * @param  \App\Http\Requests\ForumResponseRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeForumResponse(ForumResponseRequest $request)
    {
        if (!Auth::check()) {
        return redirect()->route('forumIndex')->with('error', 'Vous devez être connecté pour effectuer cette action.');
        }
        $forumResponse = new ForumResponse();
        $forumResponse->forum_post_id = $request->input('forum_post_id');
        $forumResponse->content = $request->input('content');
        $forumResponse->user_id = Auth::id();

        $forumResponse->save();

        return redirect()->route('forumIndex');
    }

    /**
     * Supprime la ressource spécifiée du stockage.
     *
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $forumResponse = ForumResponse::findOrFail($id);
        if($forumResponse->delete()){
            return redirect()->back()->with('success', 'La réponse a été supprimé avec succès.');
        }
        return redirect()->back()->with('error', 'La réponse n\'a pas pu être supprimée.');
    }

    /**
     * passe le user johnDoe a toute les reponse d'un utilisateur
     * @param int $userId
     * @param int $johnId
     * @return bool
     */
    public function fixJohnToForumResponsePostUser(int $userId, int $johnId):bool{
        $responsePosts = ForumResponse::where('user_id', $userId)->get();
        foreach ($responsePosts as $responsePost) {
            $responsePost->user_id = $johnId;
            if(!$responsePost->save()){
                return False;
            }
        }
        return True;
    }
}
