<?php

namespace App\Http\Controllers;

use App\Models\RessourcePost;
use App\Models\Category;
use App\Http\Requests\RessourcePostRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class RessourcePostController extends Controller
{

    public function storeRessourcePost(RessourcePostRequest $request)
    {
        // Validation du formulaire
        if (!Auth::check()) {
            return redirect()->route('ressource')->with('error', 'Vous devez être connecté pour effectuer cette action.');
        }
        $ressourcePosts = new RessourcePost();
        $ressourcePosts->title = $request->input('title');
        $ressourcePosts->theme_id = $request->input('theme');
        $ressourcePosts->description = $request->input('description');
        $ressourcePosts->user_id = Auth::id();

        $path = Storage::disk('local')->put('file', $request->file);

        $ressourcePosts->file_path = $path;

        //dd($ressourcePosts);
        $ressourcePosts->save();

        return redirect()->route('ressource')->with('success', 'Ressource ajoutée avec succès.');
    }

    public function downloadRessource($id)
    {
        $ressource = RessourcePost::find($id);
       // dd($ressource);
        return Storage::download($ressource->file_path);
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
        $ressourcePost = RessourcePost::find($id);
        if($ressourcePost){
            return view('admin.ressourcePostEdit', ['post' => $ressourcePost, 'categories'=>$categories]);
        }
        return redirect()->back()->with('error', "le post n'as pas été trouvé en base");
    }

    /**
     * Met à jour la ressource spécifiée dans le stockage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RessourcePostRequest $request)
    {
        $ressourcePost = RessourcePost::find($request->input('post_id'));
        if($ressourcePost){
            $ressourcePost->theme_id = $request->input('theme_id');
            if($ressourcePost->update()){
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
        $ressourcePost = RessourcePost::findOrFail($id);
        if($ressourcePost){
            if($ressourcePost->delete()){
                return redirect()->route('ressource')->with('success', 'Le post a été supprimé avec succès.');
            }
        }
        return redirect()->back()->with('error', 'Le post n\'a pas pu être supprimé.');
    }
    /**
     * met le user johnDoe sur toute les ressources du user
     * @param int $userId
     * @param int $JohnId
     * @return bool
     */
    public function fixJohnToResssource(int $userId, int $johnId):bool{
        $ressources = RessourcePost::where('user_id', $userId)->get();
        foreach ($ressources as $ressource) {
            $ressource->user_id = $johnId;
            if(!$ressource->save()){
                return False;
            }
        }
        return True;
    }
}
