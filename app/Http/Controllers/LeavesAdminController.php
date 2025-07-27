<?php

namespace App\Http\Controllers;

use App\Models\leaves;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\select;

class LeavesAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return view('auth.login');
        }

        $leaves = leaves::join('users', 'leaves.user_id', '=', 'users.id')
            ->join('departments', 'users.department_id', '=', 'departments.depart')
            ->select(
                'leaves.*',
                'users.name as user_name',
                'users.last_name as user_last_name',
                'users.photo as user_photo',
                'departments.deparment_name as department_name'
            )
            ->orderByRaw("leaves.status = 'New' DESC")
            ->get();

        $employees = User::where('statut', '=', 'Active')
            ->select('name', 'last_name', 'id')
            ->get();

        $valide = leaves::where('status', 'Approved')->count();
        $annule = leaves::where('status', 'Declined')->count();
        $encours = leaves::where('status', 'New')->count();

        return view('hrm.attendance.leaves.leaves', compact('valide', 'annule', 'encours', 'leaves', 'employees'));
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
        //
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
        $leave = leaves::findOrFail($id);

        $roles = [
            'responsable' => 'required',
            'response' => 'required',
            'reason' => 'nullable',
        ];
        $customMessages = [
            'responsable.required' => "Veuillez sélectionner le responsable de m'employé.",
            'response.required' => "Veuillez sélectionner la réponse de la demande.",
        ];

        $request->validate($roles, $customMessages);

        if ($leave->status !== $request->response) {
            $leave->status = $request->response;
        }

        $leave->approved_by = $request->responsable;
        $leave->justification = $request->reason;

        if ($leave->save()) {
            return back()->with('succes', "La réponse a été envoyer.");
        } else {
            return back()->withErrors(["Problème lors de l'envoie. Veuillez réessayer!!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
