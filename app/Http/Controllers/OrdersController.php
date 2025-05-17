<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;

use Illuminate\Http\Request;


class OrdersController extends Controller
{
   public function index(Request $request)
{
    $search = $request->input('search');  // Recherche par nom, prénom, email ou ID de commande

    // Debug: Afficher toutes les commandes avec leur statut
    \Log::info('Statuts des commandes dans la base de données:');
    \Log::info(Order::pluck('status')->unique());
    
    // Récupérer toutes les commandes avec la relation utilisateur
    $orders = Order::with('user')
        ->when($search, function ($query) use ($search) {
            $query->where(function($q) use ($search) {
                // Recherche par ID de commande
                if (is_numeric($search)) {
                    $q->where('id', $search);
                }

                // Normalisation de la recherche
                $searchLower = trim(strtolower($search));
                \Log::info('Terme recherché après normalisation: ' . $searchLower);

                // Recherche par statut avec correspondance français/anglais
                if (in_array($searchLower, ['payé', 'payée', 'paye', 'paid', 'payer', 'payés', 'payées'])) {
                    $q->orWhere('status', 'paid');
                } 
                elseif (in_array($searchLower, ['en attente', 'attente', 'pending'])) {
                    $q->orWhere('status', 'pending');
                } 
                elseif (in_array($searchLower, ['annulé', 'annulée', 'annule', 'annuler', 'cancelled', 'canceled', 'annulés', 'annulées'])) {
                    $q->orWhere(function($query) {
                        $query->where('status', 'cancelled')
                              ->orWhere('status', 'canceled');
                    });
                }

                // Recherche par utilisateur
                $q->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $search . '%']);
                });
            });
        })
        ->latest()
        ->paginate(10);

    // Statistiques
    $totalOrders = Order::count();
    $paidOrders = Order::where('status', 'paid')->count();
    $pendingOrders = Order::where('status', 'pending')->count();

    return view('admin.orders.orders', compact(
        'orders',
        'totalOrders',
        'paidOrders',
        'pendingOrders'
    ));
}


    public function edit($id)
    {
        $users = User::all();
        $order = Order::findOrFail($id);
        return view('admin.orders.edit', compact('order','users'));
    }

     public function update(Request $request, Order $order)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'cart_id' => 'required|string',
            'total_amount' => 'required|numeric',
            'status' => 'required|in:paid,pending,canceled',
        ]);

        $order->update([
            'user_id' => $request->user_id,
            'cart_id' => $request->cart_id,
            'total_amount' => $request->total_amount,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.orders')->with('success', 'Commande mise à jour avec succès!');
    }

    /**
     * Supprime une commande.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders')->with('success', 'Commande supprimée avec succès.');
    }
}
