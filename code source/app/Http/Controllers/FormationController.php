<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormationRequest;
use App\Models\Formation;
use Illuminate\Database\QueryException;

class FormationController extends Controller
{

    /**
     * Enregistre une nouvelle Formation.
     *
     * @param  \App\Http\Requests\FormationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormationRequest $request)
    {
        $Formation = Formation::create([
            'label' => $request->input('label'),
        ]);

        return redirect()->route('AdminMain')->with('success', 'La formation a été créée avec succès');
    }

}
