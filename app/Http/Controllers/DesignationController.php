<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use App\Models\Designations;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Departments::all();
        $all = Designations::join('departments', 'designations.department_id', '=', 'departments.depart')
            ->select('designations.*', 'departments.deparment_name')
            ->get();

        return view('hrm.employees.designations', compact('departments', 'all'));
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
            'libelle' => 'required|unique:designations,name_designation',
            'statut' => 'required',
            'department' => 'required',
        ];
        $customMessages = [
            'libelle.required' => "Veuillez saisir le libelle du département.",
            'libelle.unique' => $request->libelle . " existe déjà. Veuillez saisir un autre département.",
            'statut.required' => "Veuillez sélectionner le statut du département.",
            'department.required' => "Veuillez sélectionner le département.",
        ];

        $request->validate($roles, $customMessages);

        $designation = new Designations();
        $designation->name_designation = $request->libelle;
        $designation->department_id = $request->department;
        $designation->status_design = $request->statut;
        if ($designation->save()) {
            return back()->with('succes',  "Vous avez ajouter " . $request->libelle);
        } else {
            return back()->withErrors(["Impossible d'ajouter " . $request->libelle . ". Veuillez réessayer!!"]);
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
        $designation = Designations::findOrFail($id);

        $roles = [
            'libelle' => 'required',
            'statut' => 'required',
            'department' => 'required',
        ];
        $customMessages = [
            'libelle.required' => "Veuillez saisir le libelle du département.",
            'statut.required' => "Veuillez sélectionner le statut.",
            'department.required' => "Veuillez sélectionner le département.",
        ];

        $request->validate($roles, $customMessages);

        if ($designation->name_designation !== $request->libelle) {
            $designation->name_designation = $request->libelle;
        }
        if ($designation->status_design !== $request->statut) {
            $designation->status_design = $request->statut;
        }
        if ($designation->department_id !== $request->department) {
            $designation->department_id = $request->department;
        }

        if ($designation->save()) {
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
        Designations::findOrFail($id)->delete();

        return back()->with('succes', "La suppression a été effectué");
    }
}
