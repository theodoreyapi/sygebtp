<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = Departments::all();

        return view('hrm.employees.departments', compact('all'));
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
            'department' => 'required|unique:departments,deparment_name',
            'statut' => 'required',
        ];
        $customMessages = [
            'department.required' => "Veuillez saisir le libelle du département.",
            'department.unique' => $request->department . " existe déjà. Veuillez saisir un autre département.",
            'statut.required' => "Veuillez sélectionner le statut du département.",
        ];

        $request->validate($roles, $customMessages);

        $departement = new Departments();
        $departement->deparment_name = $request->department;
        $departement->status_depart = $request->statut;
        if ($departement->save()) {
            return back()->with('succes',  "Vous avez ajouter " . $request->department);
        } else {
            return back()->withErrors(["Impossible d'ajouter " . $request->department . ". Veuillez réessayer!!"]);
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
        $departement = Departments::findOrFail($id);

        $roles = [
            'department' => 'required',
            'statut' => 'required',
        ];
        $customMessages = [
            'department.required' => "Veuillez saisir le libelle du département.",
            'statut.required' => "Veuillez sélectionner le statut.",
        ];

        $request->validate($roles, $customMessages);

        if ($departement->deparment_name !== $request->department) {
            $departement->deparment_name = $request->department;
        }
        if ($departement->status_depart !== $request->statut) {
            $departement->status_depart = $request->statut;
        }

        if ($departement->save()) {
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
        Departments::findOrFail($id)->delete();

        return back()->with('succes', "La suppression a été effectué");
    }
}
