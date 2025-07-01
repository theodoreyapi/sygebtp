<?php

namespace App\Http\Controllers;

use App\Models\TrainingType;
use Illuminate\Http\Request;

class TrainingTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = TrainingType::all();
        return view('hrm.training.training-type', compact('all'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $roles = [
            'type' => 'required',
            'description' => 'required',
            'statut' => 'required',
        ];
        $customMessages = [
            'type.required' => "Veuillez saisir le type de formation.",
            'description.required' => "Veuillez saisir une petite description sur le type de formation.",
            'statut.required' => "Veuillez sélectionner le statut du type de formation.",
        ];

        $request->validate($roles, $customMessages);

        $training = new TrainingType();
        $training->type = $request->type;
        $training->description_type = $request->description;
        $training->status_type = $request->statut;
        if ($training->save()) {
            return back()->with('succes',  "Vous avez ajouter " . $request->nomtype);
        } else {
            return back()->withErrors(["Impossible d'ajouter " . $request->type . ". Veuillez réessayer!!"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $training = TrainingType::findOrFail($id);

        $roles = [
            'type' => 'required',
            'description' => 'required',
            'statut' => 'required',
        ];
        $customMessages = [
            'type.required' => "Veuillez saisir le type de formation.",
            'description.required' => "Veuillez saisir une petite description sur le type de formation.",
            'statut.required' => "Veuillez sélectionner le statut du type de formation.",
        ];

        $request->validate($roles, $customMessages);

        if ($training->status_type !== $request->statut) {
            $training->status_type = $request->statut;
        }

        $training->type = $request->type;
        $training->description_type = $request->description;

        if ($training->save()) {
            return back()->with('succes', "Vous avez modifier avec succès.");
        } else {
            return back()->withErrors(["Problème lors de la modification. Veuillez réessayer!!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        TrainingType::findOrFail($id)->delete();

        return back()->with('succes', "La suppression a été effectué");
    }
}
