<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord pour un utilisateur simple.
     */
    public function userDashboard()
    {
        return view('user.dashboard');
    }

    /**
     * Affiche le tableau de bord pour l'administrateur.
     */
    public function adminDashboard()
    {
        // Vérifie si l'utilisateur a le droit d'accès admin
        if (!Gate::allows('access-admin')) {
            abort(403, 'Accès refusé');
        }

        // Comptages pour le dashboard
        $productCount   = Product::count();
        $categoryCount  = Category::count();
        $orderCount     = Order::count();
        $userCount      = User::count();

        // Dernières commandes avec relation product
        $latestOrders = Order::with('product')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'productCount',
            'categoryCount',
            'orderCount',
            'userCount',
            'latestOrders'
        ));
    }
}
