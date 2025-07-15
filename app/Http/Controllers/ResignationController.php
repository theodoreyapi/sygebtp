<?php

namespace App\Http\Controllers;

use App\Models\Resignations;
use App\Models\User;
use Illuminate\Http\Request;

class ResignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employes = User::where('statut', '=', 'Active')
            ->select('id', 'name', 'last_name')
            ->get();

        $all = Resignations::join('users as u1', 'u1.id', '=', 'resignations.employe_id')
            ->join('departments', 'u1.department_id', '=', 'departments.depart')
            ->select(
                'resignations.*',

                // Employé (depuis u1)
                'u1.photo as employe_photo',
                'u1.name as employe_name',
                'u1.last_name as employe_last_name',
                'departments.deparment_name as employe_departement',
            )
            ->get();

        return view('hrm.resignation', compact('employes', 'all'));
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
            'demission' => 'required',
            'avis' => 'required',
        ];

        $messages = [
            'employe.required' => "Sélectionnez l'employé.",
            'raison.required' => "Saisissez la raison.",
            'demission.required' => "Choisissez la date de démission.",
            'avis.required' => "Choisissez la date.",
        ];

        $request->validate($rules, $messages);

        $demission = new Resignations();
        $demission->notice_date = $request->avis;
        $demission->resignation_date = $request->demission;
        $demission->reason = $request->raison;
        $demission->employe_id = $request->employe;
        if ($demission->save()) {
            return back()->with('succes', "Démission éffectuée avec succès.");
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
        $demission = Resignations::findOrFail($id);

        $rules = [
            'employe' => 'required',
            'raison' => 'required',
            'demission' => 'required',
            'avis' => 'required',
        ];

        $messages = [
            'employe.required' => "Sélectionnez l'employé.",
            'raison.required' => "Saisissez la raison.",
            'demission.required' => "Choisissez la date de démission.",
            'avis.required' => "Choisissez la date.",
        ];

        $request->validate($rules, $messages);

        if ($demission->employe_id !== $request->employe) {
            $demission->employe_id = $request->employe;
        }
        $demission->notice_date = $request->avis;
        $demission->resignation_date = $request->demission;
        $demission->reason = $request->raison;

        if ($demission->save()) {
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
        Resignations::findOrFail($id)->delete();

        return back()->with('succes', "La suppression a été effectué");
    }
}
