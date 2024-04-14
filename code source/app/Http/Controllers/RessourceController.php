<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Models\RessourcePost;
use Illuminate\Http\Request;

class RessourceController extends Controller
{
    public function ressource()
    {
        //classe les post par ordre de creation, du plus recent au plus ancien
        $users = User::all();
        $categories = Category::with(['themes.ressource_post' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->get();
        return view('ressourcesIndex', ['categories'=>$categories, 'users'=>$users]);
    }

    public function ressourcePostByUsers($id){
        $curentUser = User::find($id);
        if(!$curentUser) return $this->ressource();

        $users = User::all();
        $categories = Category::with(['themes.ressource_post' => function ($query) use ($id) {
            $query->whereHas('user', function ($userQuery) use ($id) {
                $userQuery->where('id', $id);
            })->orderBy('created_at', 'desc');
        }])->get();
        return view('ressourcesIndex', ['categories'=>$categories, 'users'=>$users, 'currentUser'=>$curentUser]);
    }

    public function ressourcePostByKeyWord(Request $request)
    {
        $users = User::all();

        $categories = Category::with(['themes.ressource_post' => function ($query) use ($request) {
            $keyword = $request->input('keyword');

            if ($request->has('search_type') && $request->input('search_type') == 'title_only') {
                $query->where('title', 'like', '%' . $keyword . '%');
            } else {
                $query->where(function ($subquery) use ($keyword) {
                    $subquery->where('title', 'like', '%' . $keyword . '%')
                            ->orWhere('content', 'like', '%' . $keyword . '%');
                });
            }

            $query->orderBy('created_at', 'desc');
            }])->get();

        return view('ressourcesIndex', ['categories' => $categories, 'users' => $users]);
    }

}
