<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewOrderNotification;
use App\Models\Order;
use App\Models\Product;

/*
|-------------------------------------------------------------------------- 
| Routes publiques
|-------------------------------------------------------------------------- 
*/
Route::get('/', [ProductController::class, 'home'])->name('home');

// Produit via ID
Route::get('/produit/{product}', [ProductController::class, 'show'])->name('products.show');

// Catégorie via ID
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Commande
Route::post('/commande', [OrderController::class, 'submit'])->name('order.submit');

// Route test email NewOrderNotification
Route::get('/send-new-order-email', function () {

    $order = Order::first();       // Exemple : première commande
    $product = Product::first();   // Exemple : premier produit

    if (!$order || !$product) {
        return "Aucune commande ou produit trouvé pour le test !";
    }

    Mail::to('destinataire@exemple.com')->send(new NewOrderNotification($order, $product));

    return "Email Nouvelle Commande envoyé avec succès ✅";
});

// Authentification pour les invités
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Déconnexion
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|-------------------------------------------------------------------------- 
| Routes Admin
|-------------------------------------------------------------------------- 
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

    // Profil admin
    Route::get('/profile', [UserController::class, 'editProfile'])->name('profile.index');
    Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

    /*
    |-----------------------------
    | Produits
    |-----------------------------
    */
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');

        // Suppression image
        Route::delete('/images/{image}', [ProductController::class, 'deleteImage'])->name('deleteImage');
    });

    /*
    |-----------------------------
    | Catégories
    |-----------------------------
    */
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    /*
    |-----------------------------
    | Commandes
    |-----------------------------
    */
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');

        // Route pour mettre à jour le status d'une commande
        Route::patch('/{order}/status', [OrderController::class, 'updateStatus'])->name('updateStatus');
    });

    /*
    |-----------------------------
    | Utilisateurs
    |-----------------------------
    */
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');

        // Mise à jour du rôle
        Route::patch('/{user}/role', [UserController::class, 'updateRole'])->name('updateRole');
    });

});
