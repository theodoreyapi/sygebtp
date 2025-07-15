<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use App\Models\Evaluation;
use App\Models\Objectifs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $active = User::where('statut', '=', 'Active')
            ->select('id', 'name', 'last_name')
            ->get();

        $all = Evaluation::join('users as employe', 'employe.id', '=', 'evaluations.employe_id')
            ->join('users as evaluateur', 'evaluateur.id', '=', 'evaluations.evaluateur_id')
            ->select(
                'evaluations.*',

                // Employé
                'employe.photo as employe_photo',
                'employe.name as employe_name',
                'employe.last_name as employe_last_name',

                // Evaluateur
                'evaluateur.photo as evaluateur_photo',
                'evaluateur.name as evaluateur_name',
                'evaluateur.last_name as evaluateur_last_name',
            )
            ->get();

        return view('hrm.employees.evaluations', compact('all', 'active'));
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
            'objectifs.*.objectif' => 'required',
            'objectifs.*.note' => 'required',
            'objectifs.*.appreciation' => 'required',
            'employe' => 'required',
            'debut' => 'required',
            'fin' => 'required',
            'date' => 'required',
            'evaluateur' => 'required',
            //'notes' => 'required',
            'commentaire' => 'nullable',
        ];

        $messages = [
            'objectifs.*.objectif.required' => "Veuillez saisir au moins un objectif.",
            'objectifs.*.note.required' => "Veuillez saisir au moins une note.",
            'objectifs.*.appreciation.required' => "Veuillez saisir au moins une appréciation.",
            'employe.required' => "Sélectionnez l'employé a evaluer.",
            'debut.required' => "Choisissez la période de debut d'évaluation.",
            'fin.required' => "Choisissez la période de fin d'évaluation.",
            'date.required' => "Choisissez la date de l'évaluation.",
            'evaluateur.required' => "Sélectionnez l'evaluateur.",
            //'notes.required' => "La note moyenne est obligatoire.",
        ];

        $request->validate($rules, $messages);

        $objectifs = $request->input('objectifs', []);

        // Calcul de la moyenne des notes
        $notes = collect($objectifs)->pluck('note')->filter(function ($note) {
            return is_numeric($note);
        });

        $moyenne = $notes->count() > 0 ? $notes->avg() : null;

        try {
            $eval = new Evaluation();
            $eval->note_moyenne = $moyenne;
            $eval->date_evaluation = $request->date;
            $eval->periode_debut = $request->debut;
            $eval->periode_fin = $request->fin;
            $eval->commentaire = $request->commentaire;
            $eval->employe_id = $request->employe;
            $eval->evaluateur_id = $request->evaluateur;
            if ($eval->save()) {

                foreach ($request->input('objectifs', []) as $data) {
                    Objectifs::create([
                        'objectif'     => $data['objectif'],
                        'note'         => $data['note'],
                        'appreciation' => $data['appreciation'],
                        'id_evaluation' => $eval->evaluation_id,
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => "Évaluation enregistrée avec succès.",
                ]);
            } else {

                return response()->json([
                    'success' => false,
                    'message' => "Impossible d'enregistrer l'évaluation.",
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'enregistrement : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Une erreur technique est survenue.",
                'error' => $e->getMessage(), // utile pour tester
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
     {
        $details = Evaluation::join('users as employe', 'employe.id', '=', 'evaluations.employe_id')
            ->join('users as evaluateur', 'evaluateur.id', '=', 'evaluations.evaluateur_id')
            ->where('evaluations.evaluation_id', '=', $id)
            ->select(
                'evaluations.*',

                // Employé
                'employe.photo as employe_photo',
                'employe.name as employe_name',
                'employe.last_name as employe_last_name',

                // Evaluateur
                'evaluateur.name as evaluateur_name',
                'evaluateur.last_name as evaluateur_last_name',
            )
            ->first();

        $objectifs = Objectifs::where('id_evaluation', '=', $details->evaluation_id)->get();

        return view('hrm.employees.evaluation-details', compact('details', 'objectifs'));
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
        $evaluation = Evaluation::findOrFail($id);

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

        if ($evaluation->employe_id !== $request->employe) {
            $evaluation->employe_id = $request->employe;
        }
        if ($evaluation->evaluateur_id !== $request->evaluateur) {
            $evaluation->evaluateur_id = $request->evaluateur;
        }
        $evaluation->date_evaluation = $request->date;
        $evaluation->periode_debut = $request->debut;
        $evaluation->periode_fin = $request->fin;
        $evaluation->commentaire = $request->commentaire;

        if ($evaluation->save()) {
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
        Evaluation::findOrFail($id)->delete();

        return back()->with('succes', "La suppression a été effectué");
    }
}
