<?php

namespace App\Http\Controllers;

use App\Models\Trainers;
use Illuminate\Http\Request;

class TrainersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = Trainers::all();
        return view('hrm.trainings.trainers', compact('all'));
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
            'nom' => 'required',
            'prenom' => 'required',
            'role' => 'required',
            'email' => 'required|unique:trainers,email_trai',
            'phone' => 'required|unique:trainers,phone_trai',
            'description' => '',
            'statut' => 'required',
        ];
        $customMessages = [
            'nom.required' => "Veuillez saisir son nom.",
            'prenom.required' => "Veuillez saisir son prénom.",
            'role.required' => "Veuillez saisir le sa fonction dans rôle.",
            'email.required' => "Veuillez saisir son adresse email.",
            'email.unique' => $request->email . " existe déjà. Veuillez saisir un autre email.",
            'phone.required' => "Veuillez saisir son numéro de téléphone.",
            'phone.unique' => $request->phone . " existe déjà. Veuillez saisir un autre numéro de téléphone.",
            'statut.required' => "Veuillez sélectionner le statut du formateur.",
        ];

        $request->validate($roles, $customMessages);

        $trainer = new Trainers();
        $trainer->name_trai = $request->nom;
        $trainer->lastname_trai = $request->prenom;
        $trainer->role_trai = $request->role;
        $trainer->phone_trai = $request->phone;
        $trainer->email_trai = $request->email;
        $trainer->description_trai = $request->description;
        $trainer->status_train = $request->statut;
        if ($trainer->save()) {
            return back()->with('succes',  "Vous avez ajouter " . $request->nom);
        } else {
            return back()->withErrors(["Impossible d'ajouter " . $request->nom . ". Veuillez réessayer!!"]);
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
        $trainer = Trainers::findOrFail($id);

        $roles = [
            'nom' => 'required',
            'prenom' => 'required',
            'role' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'description' => '',
            'statut' => 'required',
        ];
        $customMessages = [
            'nom.required' => "Veuillez saisir son nom.",
            'prenom.required' => "Veuillez saisir son prénom.",
            'role.required' => "Veuillez saisir le sa fonction dans rôle.",
            'email.required' => "Veuillez saisir son adresse email.",
            'phone.required' => "Veuillez saisir son numéro de téléphone.",
            'statut.required' => "Veuillez sélectionner le statut du formateur.",
        ];

        $request->validate($roles, $customMessages);

        if ($trainer->phone_trai !== $request->phone) {
            $trainer->phone_trai = $request->phone;
        }
        if ($trainer->email_trai !== $request->email) {
            $trainer->email_trai = $request->email;
        }
        if ($trainer->status_train !== $request->statut) {
            $trainer->status_train = $request->statut;
        }

        $trainer->name_trai = $request->nom;
        $trainer->lastname_trai = $request->prenom;
        $trainer->role_trai = $request->role;
        $trainer->description_trai = $request->description;

        if ($trainer->save()) {
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
        Trainers::findOrFail($id)->delete();

        return back()->with('succes', "La suppression a été effectué");
    }
}
