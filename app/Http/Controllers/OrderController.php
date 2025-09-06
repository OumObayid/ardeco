<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewOrderNotification;

class OrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Routes Admin
    |--------------------------------------------------------------------------
    */

    /**
     * Afficher la liste des commandes (Admin)
     */
    public function index()
    {
        $this->authorize('viewAny', Order::class); // Policy pour sécuriser l'accès

        $orders = Order::with('product')->latest()->get(); // pas de pagination pour ton cas
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Supprimer une commande (Admin)
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $this->authorize('delete', $order);

        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Commande supprimée avec succès.');
    }

    /**
     * Mettre à jour le status d'une commande (Admin)
     */
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $this->authorize('update', $order); // Policy pour sécuriser l'accès

        $request->validate([
            'status' => 'required|in:pending,processing,completed,canceled',
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Statut de la commande mis à jour.');
    }

    /*
    |--------------------------------------------------------------------------
    | Route publique
    |--------------------------------------------------------------------------
    */

    /**
     * Soumettre une commande (publique)
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:500',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'color' => 'nullable|string',
        ]);
        // Ajouter le statut par défaut
        $validated['status'] = 'pending';
        // Enregistrement de la commande
        $order = Order::create($validated);

        // Récupération du produit pour le mail
        $product = Product::findOrFail($validated['product_id']);
        // Récupération de l'email depuis .env
        $adminEmail = env('ADMIN_EMAIL', 'default@example.com');

        // Envoi du mail
        Mail::to($adminEmail)->send(new NewOrderNotification($order, $product));

        return back()->with('success', 'Commande envoyée avec succès ! Nous vous contacterons rapidement.');
    }
}
