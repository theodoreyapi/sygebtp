<?php

namespace App\Http\Controllers;

use App\Models\Designations;
use App\Models\Promotions;
use App\Models\User;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = Promotions::join('users as u1', 'u1.id', '=', 'promotions.employe_id')
            ->join('departments', 'u1.department_id', '=', 'departments.depart')
            ->join('designations as poste', 'promotions.promo_from', '=', 'poste.design')
            ->join('designations as monte', 'promotions.promo_to', '=', 'monte.design')
            ->select(
                'promotions.*',

                // Employé (depuis u1)
                'u1.photo as employe_photo',
                'u1.name as employe_name',
                'u1.last_name as employe_last_name',
                'departments.deparment_name as employe_departement',

                // Poste
                'poste.name_designation as poste_name',

                // Monte
                'monte.name_designation as monte_name',
            )
            ->get();

        $employes = User::where('statut', '=', 'Active')
            ->select('id', 'name', 'last_name')
            ->get();
        $designations = Designations::where('status_design', '=', 'Active')
            ->select('design', 'name_designation')
            ->get();

        return view('hrm.promotion', compact('all', 'employes', 'designations'));
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
            'promotionde' => 'required',
            'promotiona' => 'required',
            'date' => 'required',
        ];

        $messages = [
            'employe.required' => "Sélectionnez l'employé a promouvoir.",
            'promotionde.required' => "Sélectionnez sa promotion actuelle.",
            'promotiona.required' => "Sélectionnez sa nouvelle promotion.",
            'date.required' => "Choisissez la date de la promotion.",
        ];

        $request->validate($rules, $messages);

        $promotion = new Promotions();
        $promotion->date_promo = $request->date;
        $promotion->employe_id = $request->employe;
        $promotion->promo_from = $request->promotionde;
        $promotion->promo_to = $request->promotiona;
        $promotion->status_promo = "Active";
        if ($promotion->save()) {
            return back()->with('succes', "Promotion éffectuée avec succès.");
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
        $promotion = Promotions::findOrFail($id);

        $rules = [
            'employe' => 'required',
            'promotionde' => 'required',
            'promotiona' => 'required',
            'date' => 'required',
        ];

        $messages = [
            'employe.required' => "Sélectionnez l'employé a promouvoir.",
            'promotionde.required' => "Sélectionnez sa promotion actuelle.",
            'promotiona.required' => "Sélectionnez sa nouvelle promotion.",
            'date.required' => "Choisissez la date de la promotion.",
        ];

        $request->validate($rules, $messages);

        if ($promotion->employe_id !== $request->employe) {
            $promotion->employe_id = $request->employe;
        }
        if ($promotion->promo_from !== $request->promotionde) {
            $promotion->promo_from = $request->promotionde;
        }
        if ($promotion->promo_to !== $request->promotiona) {
            $promotion->promo_to = $request->promotiona;
        }
        
        $promotion->date_promo = $request->date;

        if ($promotion->save()) {
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
        Promotions::findOrFail($id)->delete();

        return back()->with('succes', "La suppression a été effectué");
    }
}
