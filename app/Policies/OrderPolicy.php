<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Détermine si l'utilisateur peut voir toutes les commandes (index).
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Détermine si l'utilisateur peut voir une commande spécifique.
     */
    public function view(User $user, Order $order): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Détermine si l'utilisateur peut créer une commande (utile si nécessaire côté admin).
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Détermine si l'utilisateur peut mettre à jour une commande.
     */
    public function update(User $user, Order $order): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Détermine si l'utilisateur peut supprimer une commande.
     */
    public function delete(User $user, Order $order): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Détermine si l'utilisateur peut restaurer une commande supprimée.
     */
    public function restore(User $user, Order $order): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Détermine si l'utilisateur peut supprimer définitivement une commande.
     */
    public function forceDelete(User $user, Order $order): bool
    {
        return $user->role === 'admin';
    }
}
