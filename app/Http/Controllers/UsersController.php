<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function index(){
        $clients = User::where('usertype', 'client')->paginate(9); // 10 clients par page
        $clientCount = User::where('usertype', 'client')->count();
        $employeCount = User::where('usertype', 'employee')->count();
        return view('admin.users.users', compact('clients', 'employeCount', 'clientCount'));
    }

    public function edit($id) {
        // Récupérer l'utilisateur par ID
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user')); // Passer l'utilisateur à la vue edit
    }

    public function update(Request $request, $id) {
        // Récupérer l'utilisateur par ID
        $user = User::findOrFail($id);

        // Validation des données
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:15',
            'gender' => 'required|in:female,male',

            'usertype' => 'required|in:client,employee',
        ]);

        // Mise à jour des données utilisateur
        $user->first_name = $validatedData['first_name'];
        $user->last_name = $validatedData['last_name'];
        $user->email = $validatedData['email'];
        $user->phone = $validatedData['phone'];
        $user->gender = $validatedData['gender'];
        $user->usertype = $validatedData['usertype'];
        $user->save();

        // Rediriger l'utilisateur vers la liste des utilisateurs avec un message de succès
        return redirect()->route('admin.users')->with('success', 'Utilisateur mis à jour avec succès! <i class="fa-solid fa-user-check"></i>');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Utilisateur supprimé avec succès. <i class="fa-solid fa-user-large-slash"></i>');
    }

}
