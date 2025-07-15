<?php

namespace App\Http\Controllers;

use App\Models\leaves;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeavesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leaves = leaves::with(['employee', 'approver'])->latest()->get();

        return view('hrm.attendance.leaves.leaves-employee', compact('leaves'));
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
            //'user_id' => 'required|exists:users,id',
            'leave_type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'day_type' => 'nullable|string',
            'reason' => 'nullable|string',
        ];
        $customMessages = [
            'leave_type.required' => "Veuillez sélectionner le type de conge.",
            'start_date.required' => "Veuillez sélectionner la date de debut.",
            'end_date.required' => "Veuillez sélectionner la date de fin.",
        ];

        $request->validate($roles, $customMessages);

        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $total_days = $start->diffInDays($end) + 1;

        if (in_array($request->day_type, ['First Half', 'Second Half'])) {
            $total_days = 0.5;
        }

        // Ensuite, crée l'objet
        $incendit = new leaves();
        $incendit->user_id = 1;
        $incendit->leave_type = $request->leave_type;
        $incendit->start_date = $start;
        $incendit->end_date = $end;
        $incendit->day_type = $request->day_type;
        $incendit->total_days = $total_days;
        $incendit->remaining_days = 8;
        $incendit->reason = $request->reason;
        $incendit->status = 'New';
        if ($incendit->save()) {
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Incident ajouté avec succès']);
            }
            return back()->with('succes', "Vous avez ajouté " . $request->leave_type);
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
