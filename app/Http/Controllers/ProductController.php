<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   public function index(Request $request)
{
    $query = Product::query();

    if ($request->filled('search')) {
        $search = $request->input('search');
        $searchLower = strtolower($search);

        $query->where(function ($q) use ($search, $searchLower) {
            // Recherche par ID
            if (is_numeric($search)) {
                $q->orWhere('id', $search);
            }

            // Recherche par nom
            $q->orWhere('name', 'like', "%{$search}%");

            // Recherche par catégorie (genre)
            if (str_contains($searchLower, 'homme') || str_contains($searchLower, 'male') || $searchLower === 'h') {
                $q->orWhere('category', 'male');
            } elseif (str_contains($searchLower, 'femme') || str_contains($searchLower, 'female') || $searchLower === 'f') {
                $q->orWhere('category', 'female');
            }

            // Recherche par statut
            if (str_contains($searchLower, 'indisponible') || str_contains($searchLower, 'unavailable')) {
                $q->orWhere('status', 'unavailable');
            } elseif (str_contains($searchLower, 'disponible') || str_contains($searchLower, 'available')) {
                $q->orWhere('status', 'available');
            }
        });
    }

    $products = $query->paginate(10)->appends($request->all());

    $totalProducts = Product::count();
    $totalAvailable = Product::where('status', 'available')->count();
    $lowStock = Product::where('status', 'available')
                      ->where('quantity', '<', 5)
                      ->count();

    return view('admin.products.products', compact(
        'products',
        'totalProducts',
        'totalAvailable',
        'lowStock'
    ));
}

    // Formulaire d'ajout
    public function create()
    {
        return view('admin.products.create_product');
    }

    // Enregistrement d'un produit
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category' => 'required|string|in:male,female',
            'status' => 'required|string|in:available,unavailable',
        ]);

        Product::create($validated);

        return redirect()->route('admin.products')->with('success', 'Produit ajouté avec succès.');
    }

    // Formulaire de modification
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    // Mise à jour d'un produit
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category' => 'required|string|in:male,female',
            'status' => 'required|string|in:available,unavailable', 
        ]);

        $product = Product::findOrFail($id);
        $product->update($validated);

        return redirect()->route('admin.products')->with('success', 'Produit mis à jour avec succès.');
    }

    // Suppression
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Produit supprimé avec succès.');
    }
}