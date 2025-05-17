<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Récupérer tous les services avec recherche
        $services = Service::when($search, function ($query) use ($search) {
            $query->where(function($q) use ($search) {
                // Recherche par ID
                if (is_numeric($search)) {
                    $q->where('id', $search);
                }
                
                // Recherche par nom seulement
                $q->orWhere('name', 'like', '%' . $search . '%');
            });
        })
        ->latest()
        ->paginate(10);

        // Statistiques
        $totalServices = Service::count();

        // Récupérer le service le plus demandé
        $mostRequestedService = Service::withCount('appointments')
            ->orderBy('appointments_count', 'desc')
            ->first();

        return view('admin.services.services', compact(
            'services',
            'totalServices',
            'mostRequestedService'
        ));
    }

    /**
     * Afficher le formulaire de création d'un service
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Enregistrer un nouveau service
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:Homme,Femme',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
        ]);

        try {
            // Convertir la catégorie de français en anglais
            $category = $request->category === 'Homme' ? 'male' : 'female';
            
            Service::create([
                'name' => $request->name,
                'description' => $request->description,
                'category' => $category,
                'price' => $request->price,
                'duration' => $request->duration,
            ]);
            
            return redirect()->route('admin.services')->with('success', 'Service créé avec succès!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la création du service: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Afficher le formulaire de modification d'un service
     */
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Mettre à jour un service
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:Homme,Femme',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
        ]);

        try {
            // Convertir la catégorie de français en anglais
            $category = $request->category === 'Homme' ? 'male' : 'female';
            
            $service->update([
                'name' => $request->name,
                'description' => $request->description,
                'category' => $category,
                'price' => $request->price,
                'duration' => $request->duration,
            ]);
            
            return redirect()->route('admin.services')->with('success', 'Service modifié avec succès!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la modification du service: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Supprimer un service
     */
    public function destroy(Service $service)
    {
        try {
            $service->delete();
            return redirect()->route('admin.services')->with('success', 'Service supprimé avec succès!');
        } catch (\Exception $e) {
            return redirect()->route('admin.services')->with('error', 'Erreur lors de la suppression du service.');
        }
    }
}
