<?php

namespace App\Http\Controllers;

use App\Models\Incendits;
use App\Models\User;
use Illuminate\Http\Request;

class IncenditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = Incendits::join('users as employe', 'employe.id', '=', 'incendits.employe_id')
            ->join('departments as departement_employe', 'departement_employe.depart', '=', 'employe.department_id')
            ->join('designations as designation_employe', 'designation_employe.design', '=', 'employe.designation_id')

            ->join('users as emetteur', 'emetteur.id', '=', 'incendits.emetteur_id')
            // ->join('departments as departement_emetteur', 'departement_emetteur.depart', '=', 'emetteur.department_id')
            // ->join('designations as designation_emetteur', 'designation_emetteur.design', '=', 'emetteur.designation_id')

            ->select(
                'incendits.*',

                // Employé
                'employe.id as employe_emp_id',
                'employe.photo as employe_photo',
                'employe.name as employe_name',
                'employe.last_name as employe_last_name',
                'departement_employe.deparment_name as employe_departement',
                'designation_employe.name_designation as employe_designation',

                // Émetteur
                'emetteur.name as emetteur_name',
                'emetteur.last_name as emetteur_last_name',
                // 'departement_emetteur.deparment_name as emetteur_departement',
                // 'designation_emetteur.name_designation as emetteur_designation'
            )
            ->orderBy('incendits.incendit_id', 'desc')
            ->get();


        $employes = User::where('statut', '=', 'Active')
            ->select('name', 'last_name', 'id')
            ->get();
        return view('hrm.attendance.attendance-incendit', compact('all', 'employes'));
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
            'date' => 'required',
            'employe' => 'required',
            'type' => 'required',
            'lieu' => 'required',
            'gravite' => 'required',
            'description' => 'required',
            'statut' => 'required',
        ];
        $customMessages = [
            'date.required' => "Veuillez saisir la date de l'évènement.",
            'employe.required' => "Veuillez sélectionner l'employé concerné.",
            'type.required' => "Veuillez sélectionner le type d'incident.",
            'lieu.required' => "Veuillez saisir le lieu ou l'incident s'est produit.",
            'gravite.required' => "Veuillez sélectionner la gravité de l'incident.",
            'description.required' => "Veuillez décrire l'incident.",
            'statut.required' => "Veuillez sélectionner le statut de l'incident.",
        ];

        $request->validate($roles, $customMessages);

        $type = $request->type;
        $annee = date('Y');

        if ($type === 'Incendit') {
            $prefix = 'INC';
        } elseif ($type === 'Accident') {
            $prefix = 'ACC';
        } else {
            $prefix = 'GEN'; // Par défaut ou autre type
        }

        // Cherche le dernier enregistrement de ce type pour l'année
        $last = Incendits::where('type_incendit', $type)
            ->whereYear('created_at', $annee)
            ->orderBy('incendit_id', 'desc')
            ->first();

        // Détermine le dernier numéro
        if ($last && preg_match('/\d+$/', $last->reference_incendit, $matches)) {
            $lastNumber = (int) $matches[0];
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '001';
        }

        // Forme la nouvelle référence
        $reference = "{$prefix}-{$annee}-{$nextNumber}";

        // Ensuite, crée l'objet
        $incendit = new Incendits();
        $incendit->reference_incendit = $reference;
        $incendit->type_incendit = $request->type;
        $incendit->lieu_incendit = $request->lieu;
        $incendit->date_incendit = $request->date;
        $incendit->description_incendit = $request->description;
        $incendit->gravite_incendit = $request->gravite;
        $incendit->statut_incendit = $request->statut;
        $incendit->employe_id = $request->employe;
        $incendit->emetteur_id = $request->employe;
        if ($incendit->save()) {
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Incident ajouté avec succès']);
            }
            return back()->with('succes', "Vous avez ajouté " . $reference);
        } else {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Impossible d\'ajouter. Veuillez réessayer.'], 500);
            }
            return back()->withErrors(["Impossible d'ajouter. Veuillez réessayer!!"]);
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
        $incendit = Incendits::findOrFail($id);

        $roles = [
            'date' => 'required',
            'employe' => 'required',
            'type' => 'required',
            'lieu' => 'required',
            'gravite' => 'required',
            'description' => 'required',
            'statut' => 'required',
        ];
        $customMessages = [
            'date.required' => "Veuillez saisir la date de l'évènement.",
            'employe.required' => "Veuillez sélectionner l'employé concerné.",
            'type.required' => "Veuillez sélectionner le type d'incident.",
            'lieu.required' => "Veuillez saisir le lieu ou l'incident s'est produit.",
            'gravite.required' => "Veuillez sélectionner la gravité de l'incident.",
            'description.required' => "Veuillez décrire l'incident.",
            'statut.required' => "Veuillez sélectionner le statut de l'incident.",
        ];

        $request->validate($roles, $customMessages);

        if ($incendit->employe_id !== $request->employe) {
            $incendit->employe_id = $request->employe;
        }
        if ($incendit->emetteur_id !== $request->employe) {
            $incendit->emetteur_id = $request->employe;
        }

        $incendit->type_incendit = $request->type;
        $incendit->lieu_incendit = $request->lieu;
        $incendit->date_incendit = $request->date;
        $incendit->description_incendit = $request->description;
        $incendit->gravite_incendit = $request->gravite;
        $incendit->statut_incendit = $request->statut;

        if ($incendit->save()) {
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
        Incendits::findOrFail($id)->delete();

        return back()->with('succes', "La suppression a été effectué");
    }
}
