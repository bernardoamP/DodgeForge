<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ForumController extends Controller
{
    /**
 * Affiche une liste de toutes les catégories avec les forum_posts, classés par ordre de création, du plus récent au plus ancien.
 *
 * @return \Illuminate\View\View
 */
    public function forumIndex() {
        //classe les post par ordre de creation, du plus recent au plus ancien
        $users = User::all();
        $categories = Category::with(['themes.forum_post' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->get();
        return view('forumIndex', ['categories'=>$categories, 'users'=>$users]);
    }

    /**
     * Affiche une liste de toutes les catégories avec les forum_posts créés par un utilisateur sélectionné.
     * Par défaut, retourne toutes les catégories avec tous les forum_posts.
     *
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function forumPostByUsers($id){
        $curentUser = User::find($id);
        if(!$curentUser) return $this->forumIndex();

        $users = User::all();
        $categories = Category::with(['themes.forum_post' => function ($query) use ($id) {
            $query->whereHas('user', function ($userQuery) use ($id) {
                $userQuery->where('id', $id);
            })->orderBy('created_at', 'desc');
        }])->get();
        return view('forumIndex', ['categories'=>$categories, 'users'=>$users, 'currentUser'=>$curentUser]);
    }

    /**
     * Affiche une liste de toutes les catégories avec les forum_posts correspondant au mot-clé sélectionné.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function forumPostByKeyWord(Request $request)
    {
        Session::put('last_keyword', $request->input('keyword'));
        $users = User::all();

        $categories = Category::with(['themes.forum_post' => function ($query) use ($request) {
            $keyword = $request->input('keyword');

            if ($request->has('titleFilter') && $request->input('titleFilter') == '1') {
                $query->where('title', 'like', '%' . $keyword . '%');
            } else {
                $query->where(function ($subquery) use ($keyword) {
                    $subquery->where('title', 'like', '%' . $keyword . '%')
                            ->orWhere('content', 'like', '%' . $keyword . '%')
                            ->orWhereHas('forum_responses', function ($responseQuery) use ($keyword) {
                                $responseQuery->Where('content', 'like', '%' . $keyword . '%');
                            });
                });
            }

            $query->orderBy('created_at', 'desc');
        }])->get();
        return view('forumIndex', ['categories' => $categories, 'users' => $users]);
    }

}
