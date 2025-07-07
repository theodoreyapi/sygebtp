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
            ->join('users as emetteur', 'emetteur.id', '=', 'incendits.emetteur_id')
            ->select(
                'incendits.*',
                'employe.name as employe_name',
                'employe.last_name as employe_last_name',
                'emetteur.name as emetteur_name',
                'emetteur.last_name as emetteur_last_name'
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
        $trainer = Incendits::findOrFail($id);

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
        Incendits::findOrFail($id)->delete();

        return back()->with('succes', "La suppression a été effectué");
    }
}
