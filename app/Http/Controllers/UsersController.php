<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.user.users', compact('users'));
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
        $user = User::findOrFail($id);

        $rules = [
            'name' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'password' => 'nullable',
            'role' => 'required',
        ];

        $messages = [
            'name.required' => "Son nom est obligatoire",
            'lastname.required' => "Son prénom est obligatoire",
            'phone.required' => "Son numéro de téléphone est obligatoire",
            'phone.unique' => "Le numéro de téléphone est déjà utilisé, veuillez utiliser un autre.",
            'email.required' => "Son email est obligatoire.",
            'email.unique' => "L'email est déjà utilisé, veuillez utiliser un autre.",
            'role' => 'Sélectionner son rôle',
        ];

        $request->validate($rules, $messages);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->last_name = $request->lastname;
        $user->phone = $request->phone;
        $user->role = $request->role;

        if ($request->password != "" || $request->password != null) {
            $user->password = Hash::make($request->password);
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
        //
    }
}
