<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Affiche tous les produits + les statistiques
    public function index()
    {
        $products = Product::paginate(10);

        // statistiques produits 🧾
        $totalProducts = Product::count();
        $totalAvailable = Product::where('status', 'available')->count();
        $lowStock = Product::where('quantity', '<', 5)->count();
        
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
        return view('admin.products.create');
    }

    // Enregistrement d'un produit
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category' => 'nullable|string|max:255',
        ]);

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produit ajouté avec succès.');
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
