<?php

namespace App\Http\Controllers;

use App\Models\Terminations;
use App\Models\User;
use Illuminate\Http\Request;

class TerminationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employes = User::where('statut', '=', 'Active')
            ->select('id', 'name', 'last_name')
            ->get();

        $all = Terminations::join('users as u1', 'u1.id', '=', 'terminations.employe_id')
            ->join('departments', 'u1.department_id', '=', 'departments.depart')
            ->select(
                'terminations.*',

                // Employé (depuis u1)
                'u1.photo as employe_photo',
                'u1.name as employe_name',
                'u1.last_name as employe_last_name',
                'departments.deparment_name as employe_departement',
            )
            ->get();

        return view('hrm.termination', compact('employes', 'all'));
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
        $rules = [
            'employe' => 'required',
            'raison' => 'required',
            'type' => 'required',
            'avis' => 'required',
            'demission' => 'required',
        ];

        $messages = [
            'employe.required' => "Sélectionnez l'employé.",
            'raison.required' => "Saisissez la raison.",
            'type.required' => "Saississez la raison.",
            'avis.required' => "Choisissez la date de l'avis.",
            'demission.required' => "Choisissez la date de démission.",
        ];

        $request->validate($rules, $messages);

        $resiliation = new Terminations();
        $resiliation->type_termi = $request->type;
        $resiliation->notice_date_termi = $request->avis;
        $resiliation->design_date_termi = $request->demission;
        $resiliation->reason_termi = $request->raison;
        $resiliation->employe_id = $request->employe;
        if ($resiliation->save()) {
            return back()->with('succes', "Fin de contrat éffectuée avec succès.");
        } else {
            return back()->withErrors(["Problème lors de la promotion. Veuillez réessayer!!"]);
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
        $resiliation = Terminations::findOrFail($id);

        $rules = [
            'employe' => 'required',
            'raison' => 'required',
            'type' => 'required',
            'avis' => 'required',
            'demission' => 'required',
        ];

        $messages = [
            'employe.required' => "Sélectionnez l'employé.",
            'raison.required' => "Saisissez la raison.",
            'type.required' => "Saississez la raison.",
            'avis.required' => "Choisissez la date de l'avis.",
            'demission.required' => "Choisissez la date de démission.",
        ];

        $request->validate($rules, $messages);

        if ($resiliation->employe_id !== $request->employe) {
            $resiliation->employe_id = $request->employe;
        }
        $resiliation->type_termi = $request->type;
        $resiliation->notice_date_termi = $request->avis;
        $resiliation->design_date_termi = $request->demission;
        $resiliation->reason_termi = $request->raison;

        if ($resiliation->save()) {
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
        Terminations::findOrFail($id)->delete();

        return back()->with('succes', "La suppression a été effectué");
    }
}
