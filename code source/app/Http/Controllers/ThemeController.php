<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Http\Requests\ThemeRequest;

class ThemeController extends Controller
{
    /**
     * Enregistre une nouvelle ressource dans le stockage.
     *
     * @param  \App\Http\Requests\ThemeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ThemeRequest $request)
    {
        $theme = Theme::create([
            'label' => $request->input('label'),
            'category_id' => $request->input('category_id'),
        ]);
        return redirect()->route('AdminMain')->with('success', 'le thème a bien été ajouté');
    }
}
