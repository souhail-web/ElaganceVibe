<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Service;
use App\Models\Appointment;
use Carbon\Carbon;


class HomeController extends Controller
{
    public function index(Request $request){
        $serviceCount = Service::count();
        $productCount = Product::count();
        
        // Compter clients et employés
        $clientCount = User::where('usertype', 'client')->count();
        $employeeCount = User::where('usertype', 'employee')->count();
        $userCount = $clientCount + $employeeCount;

        // Récupérer les rendez-vous du jour avec recherche
        $query = Appointment::with(['client', 'employee', 'service'])
            ->whereDate('date', Carbon::today());

        // Appliquer la recherche si elle existe
        if ($request->filled('search')) {
            $search = $request->input('search');
            $searchLower = strtolower($search);

            $query->where(function($q) use ($search, $searchLower) {
                // Recherche par ID
                if (is_numeric($search)) {
                    $q->orWhere('id', $search);
                }

                // Recherche par nom/prénom du client
                $q->orWhereHas('client', function($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                          ->orWhere('last_name', 'like', "%{$search}%")
                          ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ["%{$search}%"]);
                });

                // Recherche par nom/prénom de l'employé
                $q->orWhereHas('employee', function($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                          ->orWhere('last_name', 'like', "%{$search}%")
                          ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ["%{$search}%"]);
                });

                // Recherche par statut
                if (str_contains($searchLower, 'confirmé') || str_contains($searchLower, 'confirme') || str_contains($searchLower, 'confirmed')) {
                    $q->orWhere('status', 'confirmed');
                } elseif (str_contains($searchLower, 'en attente') || str_contains($searchLower, 'pending')) {
                    $q->orWhere('status', 'pending');
                } elseif (str_contains($searchLower, 'annulé') || str_contains($searchLower, 'annule') || str_contains($searchLower, 'cancelled')) {
                    $q->orWhere('status', 'cancelled');
                }
            });
        }

        $appointments = $query->orderBy('time')->paginate(5)->appends($request->all());

        return view('admin.dashboard', compact('appointments', 'productCount', 'userCount', 'serviceCount'));
    }
}
