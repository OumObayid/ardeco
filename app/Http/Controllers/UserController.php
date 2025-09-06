<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Affichage des utilisateurs (Admin)
     */
    public function index()
    {
        $this->authorize('viewAny', User::class); // Policy
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Mise à jour du rôle d'un utilisateur (Admin)
     */
    public function updateRole(Request $request, User $user)
    {
        $this->authorize('update', $user); // Policy

        $request->validate([
            'role' => 'required|in:user,admin',
        ]);

        $user->role = $request->role;
        $user->save();

        return back()->with('success', 'Rôle mis à jour avec succès.');
    }

    /**
     * Affichage du formulaire de profil
     */
    public function editProfile()
    {
        return view('admin.profile.index', ['user' => auth()->user()]);
    }

    /**
     * Mise à jour du profil
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'password'  => 'nullable|string|min:6|confirmed',
            'photo'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['firstname', 'lastname', 'email']);

        // Gestion image
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('users', 'public');
        }

        // Gestion du mot de passe
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.profile.index')
                         ->with('success', 'Profil mis à jour avec succès.');
    }

    /**
     * Suppression d'un utilisateur (Admin)
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Sécurité : empêcher l’auto-suppression
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $this->authorize('delete', $user); // Policy

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Utilisateur supprimé avec succès.');
    }
}
