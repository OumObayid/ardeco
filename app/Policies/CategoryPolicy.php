<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->role; // exemple: seulement les admins
    }

    public function view(User $user, Category $category)
    {
        return $user->role;
    }

    public function create(User $user)
    {
        return $user->role;
    }

    public function update(User $user, Category $category)
    {
        return $user->role;
    }

    public function delete(User $user, Category $category)
    {
        return $user->role;
    }
}
