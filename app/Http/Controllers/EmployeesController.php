<?php

namespace App\Http\Controllers;

use App\Models\BankInformation;
use App\Models\Departments;
use App\Models\Designations;
use App\Models\Education;
use App\Models\Experience;
use App\Models\FamilyInformation;
use App\Models\UrgenceContact;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $total = User::where('type_recru', '=', 'Recruter')->count();
        $encours = User::where('type_recru', '=', 'Encours')->count();
        $active = User::where('statut', '=', 'Active')->count();
        $inactive = User::where('statut', '=', 'Inactive')->count();

        $all = User::join('departments', 'users.department_id', '=', 'departments.depart')
            ->join('designations', 'users.designation_id', '=', 'designations.design')
            ->select(
                'departments.deparment_name',
                'designations.name_designation',
                'users.*'
            )
            ->get();

        $department = Departments::where('status_depart', '=', 'Active')->get();

        return view('hrm.employees.employees', compact('all', 'encours', 'active', 'inactive', 'total', 'department'));
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
            'recrutement' => 'required',
            'nom' => 'required',
            'prenom' => 'required',
            'phone' => 'required|unique:users,phone',
            'photo' => '',
            'email' => 'required|unique:users,email',
            'embauche' => 'required',
            'contrat' => '',
            'docontrat' => '',
            'cnps' => '',
            'diplome' => '',
            'salaire' => '',
            'departement' => 'required',
            'designation' => 'required',
            'nationnalite' => '',
            'piece' => '',
            'numero' => '',
            'naissance' => 'required',
            'lieu' => '',
            'residence' => '',
            'situation' => '',
            'sexe' => 'required',
            'enfant' => '',
            'password' => 'required',
            'about' => '',
            'role' => 'required',
        ];

        $messages = [
            'recrutement.required' => "Sélectionnez si l'employé a été recruté ou est en cours de recrutement.",
            'nom.required' => "Son nom est obligatoire",
            'prenom.required' => "Son prénom est obligatoire",
            'phone.required' => "Son numéro de téléphone est obligatoire",
            'phone.unique' => "Le numéro de téléphone est déjà utilisé, veuillez utiliser un autre.",
            'email.required' => "Son email est obligatoire.",
            'email.unique' => "L'email est déjà utilisé, veuillez utiliser un autre.",
            'embauche.required' => "Sa date d'embauche est obligatoire.",
            'departement.required' => "Sélectionnez son département.",
            'designation.required' => "Sélectionnez sa désignation (son poste qu'il occupe).",
            'naissance.required' => "Sa date de naissaince est obligatoire.",
            'sexe.required' => "Son sexe est obligatoire.",
            'password.required' => "Son mot de passe est obligatoire.",
            'role' => 'Sélectionner son rôle',
        ];

        $request->validate($rules, $messages);

        $timestamp = Carbon::now()->format('Ymd_His');

        // Photo
        if ($request->file('photo') !== null) {
            $photo = $request->file('photo');
            $photoName = 'photo_' . $timestamp . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('employe/photos'), $photoName);
            $photoPath = 'sygebtp/public/employe/photos/' . $photoName;
        }

        // Contrat
        if ($request->file('docontrat') !== null) {
            $contrat = $request->file('docontrat');
            $contratName = 'contrat_' . $timestamp . '.' . $contrat->getClientOriginalExtension();
            $contrat->move(public_path('employe/contrat'), $contratName);
            $contratPath = 'sygebtp/public/employe/contrat/' . $contratName;
        }

        // Diplome
        if ($request->file('diplome') !== null) {
            $diplome = $request->file('diplome');
            $diplomeName = 'diplome_' . $timestamp . '.' . $diplome->getClientOriginalExtension();
            $diplome->move(public_path('employe/diplome'), $diplomeName);
            $diplomePath = 'sygebtp/public/employe/diplome/' . $diplomeName;
        }

        $user = new User();
        $user->name = $request->nom;
        $user->email = $request->email;
        $user->password = hash::make($request->password);
        $user->last_name = $request->prenom;
        $user->photo = $photoPath ?? "";
        $user->date_embauche = $request->embauche;
        $user->contrat = $request->contrat;
        $user->doc_contrat = $contratPath ?? "";
        $user->cnps = $request->cnps;
        $user->doc_diplome = $diplomePath ?? "";
        $user->salaire = $request->salaire;
        $user->nationnalite = $request->nationnalite;
        $user->type_papier = $request->piece;
        $user->numero_papier = $request->numero;
        $user->date_naissance = $request->naissance;
        $user->lieu_naissance = $request->lieu;
        $user->lieu_residence = $request->residence;
        $user->situation_matrimoniale = $request->situation;
        $user->sexe = $request->sexe;
        $user->enfant = $request->enfant;
        $user->phone = $request->phone;
        $user->department_id = $request->departement;
        $user->designation_id = $request->designation;
        $user->type_recru = $request->recrutement;
        $user->about = $request->about;
        $user->role = $request->role;
        if ($user->save()) {
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
        $details = User::join('departments', 'users.department_id', '=', 'departments.depart')
            ->join('designations', 'users.designation_id', '=', 'designations.design')
            ->where('users.id', $id)
            ->select(
                'departments.deparment_name',
                'designations.name_designation',
                'users.*'
            )
            ->first();
        $banks = BankInformation::where('employe_id', '=', $details->id)->get();
        $education = Education::where('employe_id', '=', $details->id)->get();
        $experience = Experience::where('employe_id', '=', $details->id)->get();
        $family = FamilyInformation::where('employe_id', '=', $details->id)->get();
        $urgences = UrgenceContact::where('employe_id', '=', $details->id)->get();

        return view('hrm.employees.employee-details', compact('details', 'banks', 'education', 'experience', 'family', 'urgences'));
    }

    public function getDesignations($departement_id)
    {
        $designations = Designations::where('department_id', $departement_id)
            ->where('status_design', '=', 'Active')
            ->get();

        return response()->json($designations);
    }


    public function bank(Request $request, $id)
    {
        $rules = [
            'libelle' => 'required',
            'code' => 'required',
            'guichet' => 'required',
            'numero' => 'required',
            'rib' => 'required',
            'iban' => 'required',
            'swift' => 'required',
        ];

        $messages = [
            'libelle.required' => "Renseignez le nom de la banque.",
            'code.required' => "Renseignez le code de la banque.",
            'guichet.required' => "Renseignez le code guichet.",
            'numero.required' => "Renseignez le numéro de compte.",
            'rib.required' => "Renseignez le RIB du compte.",
            'iban.required' => "Renseignez le RIB.",
            'swift.required' => "Renseignez le swift.",
        ];

        $request->validate($rules, $messages);

        $bank = new BankInformation();
        $bank->name_bank = $request->libelle;
        $bank->code_bank = $request->code;
        $bank->code_guichet_bank = $request->guichet;
        $bank->number_compte_bank = $request->numero;
        $bank->cle_rib_bank = $request->rib;
        $bank->iban_bank = $request->iban;
        $bank->swift_bank = $request->swift;
        $bank->employe_id = $id;
        if ($bank->save()) {
            return back()->with('succes',  "Vous avez ajouter " . $request->libelle);
        } else {
            return back()->withErrors(["Impossible d'ajouter " . $request->libelle . ". Veuillez réessayer!!"]);
        }
    }

    public function famille(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'lien' => 'required',
            'phone' => 'nullable',
            'date' => 'nullable',
        ];

        $messages = [
            'name.required' => "Renseignez son nom et prénom.",
            'lien.required' => "Renseignez le lien familliale.",
        ];

        $request->validate($rules, $messages);

        $famille = new FamilyInformation();
        $famille->complet_name = $request->name;
        $famille->relation_family = $request->lien;
        $famille->phone_family = $request->phone;
        $famille->naissance_family = $request->date;
        $famille->employe_id = $id;
        if ($famille->save()) {
            return back()->with('succes',  "Vous avez ajouter " . $request->name);
        } else {
            return back()->withErrors(["Impossible d'ajouter " . $request->name . ". Veuillez réessayer!!"]);
        }
    }

    public function experience(Request $request, $id)
    {
        $rules = [
            'entreprise' => 'required',
            'poste' => 'required',
            'debut' => 'required',
            'fin' => 'nullable',
            'present' => 'nullable',
        ];

        $messages = [
            'entreprise.required' => "Renseignez le nom de l'entreprise.",
            'poste.required' => "Renseignez le poste que vous avez occupé.",
            'debut.required' => "Renseignez la date de debut.",
        ];

        $request->validate($rules, $messages);

        $experience = new Experience();
        $experience->entreprise = $request->entreprise;
        $experience->poste = $request->poste;
        $experience->en_poste = $request->has('present') ? 1 : 0;
        $experience->debut = $request->debut;
        $experience->fin = $request->fin;
        $experience->employe_id = $id;
        if ($experience->save()) {
            return back()->with('succes',  "Vous avez ajouter " . $request->name);
        } else {
            return back()->withErrors(["Impossible d'ajouter " . $request->name . ". Veuillez réessayer!!"]);
        }
    }

    public function updateExperience(Request $request, $id)
    {
        $rules = [
            'entreprise' => 'required',
            'poste' => 'required',
            'debut' => 'required',
            'fin' => 'nullable',
            'present' => 'nullable',
        ];

        $messages = [
            'entreprise.required' => "Renseignez le nom de l'entreprise.",
            'poste.required' => "Renseignez le poste que vous avez occupé.",
            'debut.required' => "Renseignez la date de debut.",
        ];

        $request->validate($rules, $messages);

        $experience = Experience::findOrFail($id);
        $experience->entreprise = $request->entreprise;
        $experience->poste = $request->poste;
        $experience->en_poste = $request->has('present') ? 1 : 0;
        $experience->debut = $request->debut;
        $experience->fin = $request->fin;
        $experience->employe_id = $id;
        $experience->save();

        return response()->json(['success' => true]);
    }

    public function deleteExperience($id)
    {
        Experience::findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }

    public function education(Request $request, $id)
    {
        $rules = [
            'school' => 'required',
            'formation' => 'required',
            'start' => 'required',
            'end' => 'required',
        ];

        $messages = [
            'school.required' => "Renseignez le nom de l'établissement.",
            'formation.required' => "Renseignez le nom de la formation.",
            'start.required' => "Renseignez la date de commencement.",
            'end.required' => "Renseignez la date de fin.",
        ];

        $request->validate($rules, $messages);

        $education = new Education();
        $education->school = $request->school;
        $education->formation = $request->formation;
        $education->debut = $request->start;
        $education->fin = $request->end;
        $education->employe_id = $id;
        if ($education->save()) {

            if ($request->ajax()) {
                return response()->json(['success' => true]);
            }

            return back()->with('succes',  "Vous avez ajouter " . $request->school);
        } else {
            return back()->withErrors(["Impossible d'ajouter " . $request->school . ". Veuillez réessayer!!"]);
        }
    }

    public function updateEducation(Request $request, $id)
    {
        $request->validate([
            'school' => 'required',
            'formation' => 'required',
            'debut' => 'required',
            'fin' => 'required',
        ]);

        $education = Education::findOrFail($id);
        $education->school = $request->school;
        $education->formation = $request->formation;
        $education->debut = $request->debut;
        $education->fin = $request->fin;
        $education->save();

        return response()->json(['success' => true]);
    }

    public function deleteEducation($id)
    {
        Education::findOrFail($id)->delete();

        return response()->json(['success' => true]);
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
            'recrutement' => 'required',
            'nom' => 'required',
            'prenom' => 'required',
            'phone' => 'required',
            'photo' => '',
            'email' => 'required',
            'embauche' => 'required',
            'contrat' => '',
            'docontrat' => '',
            'cnps' => '',
            'diplome' => '',
            'salaire' => '',
            'departement' => 'required',
            'designation' => 'required',
            'nationnalite' => '',
            'piece' => '',
            'numero' => '',
            'naissance' => 'required',
            'lieu' => '',
            'residence' => '',
            'situation' => '',
            'sexe' => 'required',
            'enfant' => '',
            'password' => '',
            'about' => '',
            'role' => 'required',
        ];

        $messages = [
            'recrutement.required' => "Sélectionnez si l'employé a été recruté ou est en cours de recrutement.",
            'nom.required' => "Son nom est obligatoire",
            'prenom.required' => "Son prénom est obligatoire",
            'phone.required' => "Son numéro de téléphone est obligatoire",
            'phone.unique' => "Le numéro de téléphone est déjà utilisé, veuillez utiliser un autre.",
            'email.required' => "Son email est obligatoire.",
            'email.unique' => "L'email est déjà utilisé, veuillez utiliser un autre.",
            'embauche.required' => "Sa date d'embauche est obligatoire.",
            'departement.required' => "Sélectionnez son département.",
            'designation.required' => "Sélectionnez sa désignation (son poste qu'il occupe).",
            'naissance.required' => "Sa date de naissaince est obligatoire.",
            'sexe.required' => "Son sexe est obligatoire.",
            'role' => 'Sélectionner son rôle',
        ];

        $request->validate($rules, $messages);

        $timestamp = Carbon::now()->format('Ymd_His');

        // Photo
        if ($request->file('photo') !== null) {
            $photo = $request->file('photo');
            $photoName = 'photo_' . $timestamp . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('employe/photos'), $photoName);
            $photoPath = 'sygebtp/public/employe/photos/' . $photoName;
        }

        // Contrat
        if ($request->file('docontrat') !== null) {
            $contrat = $request->file('docontrat');
            $contratName = 'contrat_' . $timestamp . '.' . $contrat->getClientOriginalExtension();
            $contrat->move(public_path('employe/contrat'), $contratName);
            $contratPath = 'sygebtp/public/employe/contrat/' . $contratName;
        }

        // Diplome
        if ($request->file('diplome') !== null) {
            $diplome = $request->file('diplome');
            $diplomeName = 'diplome_' . $timestamp . '.' . $diplome->getClientOriginalExtension();
            $diplome->move(public_path('employe/diplome'), $diplomeName);
            $diplomePath = 'sygebtp/public/employe/diplome/' . $diplomeName;
        }

        $user = new User();
        $user->name = $request->nom;
        $user->email = $request->email;
        $user->last_name = $request->prenom;
        $user->photo = $photoPath ?? "";
        $user->date_embauche = $request->embauche;
        $user->contrat = $request->contrat;
        $user->doc_contrat = $contratPath ?? "";
        $user->cnps = $request->cnps;
        $user->doc_diplome = $diplomePath ?? "";
        $user->salaire = $request->salaire;
        $user->nationnalite = $request->nationnalite;
        $user->type_papier = $request->piece;
        $user->numero_papier = $request->numero;
        $user->date_naissance = $request->naissance;
        $user->lieu_naissance = $request->lieu;
        $user->lieu_residence = $request->residence;
        $user->situation_matrimoniale = $request->situation;
        $user->sexe = $request->sexe;
        $user->enfant = $request->enfant;
        $user->phone = $request->phone;
        $user->department_id = $request->departement;
        $user->designation_id = $request->designation;
        $user->type_recru = $request->recrutement;
        $user->about = $request->about;
        $user->role = $request->role;

        if ($request->password != "" || $request->password != null) {
            $user->password = hash::make($request->password);
        }

        if ($user->save()) {
            return back()->with('succes',  "Les informations de " . $request->nom . " ont été modifier");
        } else {
            return back()->withErrors(["Impossible de modifer. Veuillez réessayer!!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::find($id)->delete();

        return back()->with('succes',  "Suppression faite");
    }
}
