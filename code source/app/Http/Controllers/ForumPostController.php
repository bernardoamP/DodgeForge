<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ForumPost;
use App\Http\Requests\ForumPostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ForumPostController extends Controller
{
    /**
     * Affiche une liste de toutes les ressources.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $forumPosts = ForumPost::all();
        return view('forumIndex', ['forumPosts'=>$forumPosts]);
    }

    /**
     * Affiche un forum_post spécifique.
     *
     * @param int $id ID du forum_post à afficher
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        $categories = Category::all();
        $forumPost = ForumPost::find($id);
        if($forumPost){
            return view('admin.forumPostEdit', ['post' => $forumPost, 'categories'=>$categories]);
        }
        return redirect()->back()->with('error', "le post n'as pas été trouvé en base");
    }

    /**
     * Enregistre une nouvelle ressource dans le stockage.
     *
     * @param  \App\Http\Requests\ForumPostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeForumPost(ForumPostRequest $request)
    {
        if (!Auth::check()) {
            return redirect()->route('forumIndex')->with('error', 'Vous devez être connecté pour effectuer cette action.');
        }
        // Création d'une nouvelle ressource ForumPost
        $forumPost = new ForumPost();
        $forumPost->title = $request->input('title');
        $forumPost->theme_id = $request->input('theme');
        $forumPost->content = $request->input('content');
        $forumPost->user_id = Auth::id();

        $forumPost->save();

        return redirect()->route('forumIndex');
    }

    /**
     * Met à jour la ressource spécifiée dans le stockage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $forumPost = ForumPost::find($request->input('post_id'));
        if($forumPost){
            $forumPost->theme_id = $request->input('theme_id');
            if($forumPost->update()){
            return redirect()->back()->with('success', 'modification effectuée');
            }
        }
        return redirect()->back()->with('error', 'la modification à échouée');
    }

    /**
     * Supprime la ressource spécifiée du stockage.
     *
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $forumPost = ForumPost::findOrFail($id);
        if($forumPost){
            if($forumPost->delete()){
                return redirect()->route('forumIndex')->with('success', 'Le post a été supprimé avec succès.');
            }
        }
        return redirect()->back()->with('error', 'Le post n\'a pas pu être supprimé.');
    }

    /**
     * Assigne tout les post d'un uitilisateur a johnDoe
     * @param int $userId
     * @param int $JohnId
     * @return bool
     */
    public function fixJohnToForumPostUser(int $userId, int $JohnId) : bool{
        $posts = ForumPost::where('user_id', $userId)->get();
        foreach ($posts as $post) {
            $post->user_id = $JohnId;
            if(!$post->save()){
                return False;
            }
        }
        return True;
    }
}
