<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Formation;
use App\Models\User;

class AdminPageController extends Controller
{
    /**
     * Renvoie la page principale d'administration avec les listes de catégories, de formations et d'utilisateurs.
     *@return \Illuminate\View\View
     */
    public function mainPage(){

        $categories = Category::all();
        $formations = Formation::all();
        $users = User::all();

        return view('admin.main', [
            'categories' => $categories,
            'formations'=> $formations,
            'users' => $users
        ]);
    }
}
