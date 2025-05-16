<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        // === Requête de base ===
        $clientQuery = User::where('usertype', 'client');
        $employeeQuery = User::where('usertype', 'employee');

        // === Si recherche active ===
        if ($request->has('search')) {
            $search = $request->input('search');

            // Si l'entrée est un ID numérique
            if (ctype_digit($search)) {
                $clientQuery->where('id', (int) $search);
                $employeeQuery->where('id', (int) $search);
            } else {
                // Vérifier si la recherche contient un espace (nom complet)
                $terms = explode(' ', $search);
                
                if (count($terms) > 1) {
                    // Recherche par nom complet
                    $firstName = $terms[0];
                    $lastName = $terms[1];
                    
                    $clientQuery->where(function ($q) use ($firstName, $lastName) {
                        $q->where(function ($query) use ($firstName, $lastName) {
                            $query->where('first_name', 'like', "$firstName%")
                                  ->where('last_name', 'like', "$lastName%");
                        });
                    });

                    $employeeQuery->where(function ($q) use ($firstName, $lastName) {
                        $q->where(function ($query) use ($firstName, $lastName) {
                            $query->where('first_name', 'like', "$firstName%")
                                  ->where('last_name', 'like', "$lastName%");
                        });
                    });
                } else {
                    // Recherche par nom simple ou email
                    $clientQuery->where(function ($q) use ($search) {
                        $q->where('first_name', 'like', "$search%")
                          ->orWhere('last_name', 'like', "$search%")
                          ->orWhere('email', 'like', "$search%");
                    });

                    $employeeQuery->where(function ($q) use ($search) {
                        $q->where('first_name', 'like', "$search%")
                          ->orWhere('last_name', 'like', "$search%")
                          ->orWhere('email', 'like', "$search%");
                    });
                }
            }
        }

        $clients = $clientQuery->paginate(5, ['*'], 'clients');
        $employees = $employeeQuery->paginate(5, ['*'], 'employees');

        $clientCount = User::where('usertype', 'client')->count();
        $employeCount = User::where('usertype', 'employee')->count();

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
            'specialty' => 'nullable|string|max:255',
            'availability' => 'nullable|string|max:255',
        ]);

        $user->update($validatedData);

        return redirect()->route('admin.users')->with('success', 'Utilisateur mis à jour avec succès! <i class="fa-solid fa-user-check"></i>');
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $user = User::findOrFail($id);
            
            // Vérifier les relations existantes
            if ($user->usertype === 'client') {
                $hasAppointments = $user->clientAppointments()->exists();
                $hasOrders = $user->orders()->exists();
                
                if ($hasAppointments || $hasOrders) {
                    DB::rollBack();
                    $message = '';
                    
                    if ($hasAppointments && $hasOrders) {
                        $message = 'Impossible de supprimer ce client car il a des rendez-vous programmés et des commandes en cours. Veuillez d\'abord annuler ses rendez-vous et traiter ses commandes.';
                    } elseif ($hasAppointments) {
                        $message = 'Impossible de supprimer ce client car il a des rendez-vous programmés. Veuillez d\'abord annuler ou compléter ses rendez-vous.';
                    } elseif ($hasOrders) {
                        $message = 'Impossible de supprimer ce client car il a des commandes en cours. Veuillez d\'abord traiter ses commandes.';
                    }
                    
                    return redirect()->route('admin.users')
                        ->with('error', $message . ' <i class="fas fa-exclamation-triangle"></i>');
                }
                
                $user->clientAppointments()->delete();
            } elseif ($user->usertype === 'employee') {
                $hasAppointments = $user->employeeAppointments()->exists();
                
                if ($hasAppointments) {
                    DB::rollBack();
                    return redirect()->route('admin.users')
                        ->with('error', 'Impossible de supprimer cet employé car il a des rendez-vous programmés avec des clients. Veuillez d\'abord réaffecter ou annuler ses rendez-vous. <i class="fas fa-exclamation-triangle"></i>');
                }
                
                $user->employeeAppointments()->delete();
            }
            
            // Si on arrive ici, on peut supprimer l'utilisateur
            $user->delete();
            
            DB::commit();
            return redirect()->route('admin.users')
                ->with('success', ($user->usertype === 'client' ? 'Client' : 'Employé') . ' supprimé avec succès. <i class="fa-solid fa-user-large-slash"></i>');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.users')
                ->with('error', 'Une erreur inattendue est survenue lors de la suppression. Veuillez réessayer. <i class="fas fa-exclamation-triangle"></i>');
        }
    }

    public function create()
    {
        return view('admin.users.create_employee');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:15',
            'gender' => 'required|in:female,male',
            'usertype' => 'required|in:employee',
            'specialty' => 'required|string|max:255',
            'availability' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create($validated);

        return redirect()->route('admin.users')->with('success', 'Employé ajouté avec succès ! <i class="fa-solid fa-user-plus"></i>');
    }
}
