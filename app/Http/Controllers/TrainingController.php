<?php

namespace App\Http\Controllers;

use App\Models\AssoTypeTraining;
use App\Models\Trainers;
use App\Models\Training;
use App\Models\TrainingType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = Training::leftJoin('asso_type_training', 'training.traini', '=', 'asso_type_training.formation_id')
            ->leftJoin('users', 'users.id', '=', 'asso_type_training.employe_id')
            ->join('trainers', 'training.trainer_id', '=', 'trainers.trai') // correction ici
            ->join('training_type', 'training.type_id', '=', 'training_type.trai_type') // correction ici
            ->select(
                'training.traini',
                'training.type_id',
                'training.trainer_id',
                'training.cost_traini',
                'training.start_traini',
                'training.end_traini',
                'training.status_traini',
                'training.description_traini',

                'training_type.type',

                'trainers.name_trai',
                'trainers.lastname_trai',

                'users.id as employe_id',
                'users.photo as employe_photo',
                'users.name as employe_name',
                'users.last_name as employe_last_name'
            )
            ->orderBy('training.traini')
            ->get()
            ->groupBy('traini');

        $employes = User::where('statut', '=', 'Active')->get();
        $formateurs = Trainers::where('status_train', '=', 'Active')->get();
        $types = TrainingType::where('status_type', '=', 'Active')->get();

        return view('hrm.training.training', compact('all', 'employes', 'formateurs', 'types'));
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
            'type' => 'required',
            'employe' => 'required',
            'formateur' => 'required',
            'cout' => 'required',
            'debut' => 'required',
            'fin' => 'required',
            'statut' => 'required',
            'description' => 'nullable',
        ];

        $messages = [
            'type.required' => "Veuillez saisir au moins un objectif.",
            'employe.required' => "Sélectionnez l'employé a evaluer.",
            'formateur.required' => "Choisissez la période de debut d'évaluation.",
            'cout.required' => "Choisissez la période de fin d'évaluation.",
            'debut.required' => "Choisissez la date de l'évaluation.",
            'fin.required' => "Sélectionnez l'evaluateur.",
            'statut.required' => "Sélectionnez l'evaluateur.",
        ];

        $request->validate($rules, $messages);


        $eval = new Training();
        $eval->type_id = $request->type;
        $eval->trainer_id = $request->formateur;
        $eval->cost_traini = $request->cout;
        $eval->start_traini = $request->debut;
        $eval->end_traini = $request->fin;
        $eval->status_traini = $request->statut;
        $eval->description_traini = $request->description;
        if ($eval->save()) {

            foreach ($request->employe as $employeId) {
                AssoTypeTraining::create([
                    'employe_id' => $employeId,
                    'formation_id' => $eval->traini,
                ]);
            }
            return back()->with('succes', "Vous ajouter une formation avec succès.");
        } else {
            return back()->withErrors(["Problème lors de l'ajout. Veuillez réessayer!!"]);
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
        $rules = [
            'employe' => 'required',
            'debut' => 'required',
            'fin' => 'required',
            'date' => 'required',
            'evaluateur' => 'required',
            'commentaire' => 'nullable',
        ];

        $messages = [
            'employe.required' => "Sélectionnez l'employé a evaluer.",
            'debut.required' => "Choisissez la période de debut d'évaluation.",
            'fin.required' => "Choisissez la période de fin d'évaluation.",
            'date.required' => "Choisissez la date de l'évaluation.",
            'evaluateur.required' => "Sélectionnez l'evaluateur.",
        ];

        $request->validate($rules, $messages);

        $eval = Training::findOrFail($id);
        $eval->type_id = $request->type;
        $eval->trainer_id = $request->formateur;
        $eval->cost_traini = $request->cout;
        $eval->start_traini = $request->debut;
        $eval->end_traini = $request->fin;
        $eval->status_traini = $request->statut;
        $eval->description_traini = $request->description;

        if ($eval->save()) {
            // On supprime les anciennes associations
            AssoTypeTraining::where('formation_id', $eval->traini)->delete();

            // On ajoute les nouvelles
            foreach ($request->employe as $employeId) {
                AssoTypeTraining::create([
                    'employe_id' => $employeId,
                    'formation_id' => $eval->traini,
                ]);
            }

            return back()->with('succes', "La formation a été mise à jour avec succès.");
        } else {
            return back()->withErrors(["Problème lors de la mise à jour. Veuillez réessayer."]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Training::findOrFail($id)->delete();

        return back()->with('succes', "La suppression a été effectué");
    }
}
