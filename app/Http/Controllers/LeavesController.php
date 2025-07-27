<?php

namespace App\Http\Controllers;

use App\Models\leaves;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeavesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leaves = leaves::where('user_id', Auth::user()->id)->get();

        // Définir les types
        $types = ['Annual', 'Medical', 'Casual', 'Autres'];

        // Initialisation
        $leaveStats = [];

        foreach ($types as $type) {
            // Total de jours pris pour ce type
            $daysTaken = leaves::where('user_id', Auth::user()->id)
                ->where('leave_type', $type)
                ->where('status', 'Approved') // seulement les approuvés
                ->get()
                ->sum(function ($leave) {
                    return Carbon::parse($leave->start_date)->diffInDays(Carbon::parse($leave->end_date)) + 1;
                });

            // Pour les congés annuels, on calcule les jours acquis (2.5 par mois)
            if ($type === 'Annual') {
                $employee = User::find(Auth::user()->id);
                $dateStart = $employee->hire_date ?? now(); // Date d'embauche

                $monthsWorked = Carbon::parse($dateStart)->diffInMonths(now());
                $acquiredDays = $monthsWorked * 2.5;

                $remaining = max(0, $acquiredDays - $daysTaken);
            } else {
                // Pour les autres types, tu peux fixer un quota si besoin, sinon 0
                $remaining = null; // ou ex: 10 - $daysTaken
            }

            $leaveStats[$type] = [
                'taken' => $daysTaken,
                'remaining' => $remaining,
            ];
        }

        return view('hrm.attendance.leaves.leaves-employee', compact('leaves', 'leaveStats'));
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
            'leave_type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            // 'day_type' => 'nullable|string',
            'reason' => 'nullable|string',
        ];

        $messages = [
            'leave_type.required' => "Veuillez sélectionner le type de congé.",
            'start_date.required' => "Veuillez sélectionner la date de début.",
            'end_date.required' => "Veuillez sélectionner la date de fin.",
        ];

        $request->validate($rules, $messages);

        $user = Auth::user();
        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);

        // Acquisition mensuelle depuis la date d'embauche
        $startDate = Carbon::parse($user->date_embauche);
        $monthsWorked = $startDate->diffInMonths(now());
        $totalAcquired = $monthsWorked * 2.5;

        // Jours déjà consommés
        $daysTaken = Leaves::where('user_id', $user->id)
            ->where('status', '!=', 'Declined')
            ->sum('total_days');

        $remaining_days = max($totalAcquired - $daysTaken, 0);

        // Calcul des jours demandés
        $total_days = in_array($request->day_type, ['First Half', 'Second Half'])
            ? 0.5
            : $start->diffInDays($end) + 1;

        if ($total_days > $remaining_days) {
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => "Vous n’avez pas assez de jours de congés. Il vous reste $remaining_days jours."], 500)
                : back()->withErrors(['message' => "Vous n’avez pas assez de jours de congés. Il vous reste $remaining_days jours."]);
        }

        // Enregistrement du congé
        $leave = new leaves();
        $leave->user_id = $user->id;
        $leave->leave_type = $request->leave_type;
        $leave->start_date = $start;
        $leave->end_date = $end;
        //$leave->day_type = $request->day_type;
        $leave->total_days = $total_days;
        $leave->remaining_days = $remaining_days - $total_days;
        $leave->reason = $request->reason;
        $leave->status = 'New';
        if ($leave->save()) {
            return $request->ajax()
                ? response()->json(['success' => true, 'message' => 'Congé ajouté avec succès'])
                : back()->with('succes', "Votre demande de congé a été envoyé avec succès.");
        } else {
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => 'Impossible d\'envoyer votre demande. Veuillez réessayer.'], 500)
                : back()->withErrors(["Impossible d'envoyer votre demande. Veuillez réessayer !!"]);
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
        $incendit = leaves::findOrFail($id);

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
        leaves::findOrFail($id)->delete();

        return back()->with('succes', "La suppression a été effectué");
    }
}
