<?php

namespace App\Http\Controllers;

use App\Models\Holidays;
use Illuminate\Http\Request;

class HolidaysController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = Holidays::all();
        return view('hrm.holidays', compact('all'));
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
            'titre' => 'required|unique:holidays,title',
            'date' => 'required',
            'description' => 'required',
            'statut' => 'required',
        ];
        $customMessages = [
            'titre.required' => "Veuillez saisir le titre du férié.",
            'titre.unique' => $request->titre . " existe déjà. Veuillez saisir un autre titre.",
            'date.required' => "Veuillez sélectionner la date du férié.",
            'description.required' => "Veuillez saisir la description du férié.",
            'statut.required' => "Veuillez sélectionner le statut du férié.",
        ];

        $request->validate($roles, $customMessages);

        $holiday = new Holidays();
        $holiday->title = $request->titre;
        $holiday->description = $request->description;
        $holiday->date = $request->date;
        $holiday->status_holi = $request->statut;
        if ($holiday->save()) {
            return back()->with('succes',  "Vous avez ajouter " . $request->titre);
        } else {
            return back()->withErrors(["Impossible d'ajouter " . $request->titre . ". Veuillez réessayer!!"]);
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
        $holiday = Holidays::findOrFail($id);

        $roles = [
            'titre' => 'required',
            'date' => 'required',
            'description' => 'required',
            'statut' => 'required',
        ];
        $customMessages = [
            'titre.required' => "Veuillez saisir le titre du férié.",
            'date.required' => "Veuillez sélectionner la date du férié.",
            'description.required' => "Veuillez saisir la description du férié.",
            'statut.required' => "Veuillez sélectionner le statut du férié.",
        ];

        $request->validate($roles, $customMessages);

        if ($holiday->title !== $request->titre) {
            $holiday->title = $request->titre;
        }
        if ($holiday->status_holi !== $request->statut) {
            $holiday->status_holi = $request->statut;
        }

        $holiday->description = $request->description;
        $holiday->date = $request->date;

        if ($holiday->save()) {
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
        Holidays::findOrFail($id)->delete();

        return back()->with('succes', "La suppression a été effectué");
    }
}
