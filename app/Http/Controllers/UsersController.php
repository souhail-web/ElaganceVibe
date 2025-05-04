<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        // === Recherche pour les clients ===
        $clientQuery = User::where('usertype', 'client');
        // === Recherche pour les employés ===
        $employeeQuery = User::where('usertype', 'employee');

        if ($request->has('search')) {
            $search = $request->input('search');

            $clientQuery->where(function ($q) use ($search) {
                $q->where('id', $search)
                  ->orWhere('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });

            $employeeQuery->where(function ($q) use ($search) {
                $q->where('id', $search)
                  ->orWhere('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        $clients = $clientQuery->paginate(9, ['*'], 'clients');
        $employees = $employeeQuery->paginate(9, ['*'], 'employees');

        $clientCount = User::where('usertype', 'client')->count();
        $employeCount = User::where('usertype', 'employee')->count();

        // Clients inscrits ce mois-ci (au moment de l'inscription)
        $clientsThisMonth = User::where('usertype', 'client')
            ->whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])
            ->count();

        return view('admin.users.users', compact(
            'clients', 
            'employees', 
            'clientCount', 
            'employeCount', 
            'clientsThisMonth'
        ));
    }

    // edit, update, destroy (inchangés)
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:15',
            'gender' => 'required|in:female,male',
            'usertype' => 'required|in:client,employee',
        ]);

        $user->update($validatedData);

        return redirect()->route('admin.users')->with('success', 'Utilisateur mis à jour avec succès! <i class="fa-solid fa-user-check"></i>');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Utilisateur supprimé avec succès. <i class="fa-solid fa-user-large-slash"></i>');
    }
}
