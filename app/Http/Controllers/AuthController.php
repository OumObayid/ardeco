<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Affiche le formulaire de connexion.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Affiche le formulaire d'inscription publique.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Traitement de l'inscription publique.
     */
    public function register(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname'  => $request->lastname,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'user', // rôle par défaut pour inscription publique
        ]);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Utilisateur créé avec succès'], 201);
        }

        return redirect()->route('login')->with('success', 'Compte créé avec succès. Connectez-vous !');
    }

    /**
     * Traitement de la connexion.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Optionnel : limiter les tentatives pour éviter le brute force
        // $this->validateLoginAttempts($request);

        if (!Auth::attempt($credentials)) {
            return $request->expectsJson()
                ? response()->json(['message' => 'Identifiants incorrects'], 401)
                : back()->with('error', 'Email ou mot de passe incorrect.');
        }

        $user = Auth::user();

        if ($request->expectsJson()) {
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'token' => $token,
                'user'  => $user,
            ]);
        }

        return redirect()->route($user->role === 'admin' ? 'admin.dashboard' : 'home');
    }

    /**
     * Déconnexion de l'utilisateur.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $request->expectsJson()
            ? response()->json(['message' => 'Déconnexion réussie'])
            : redirect()->route('login');
    }

    /**
     * Création d’un utilisateur depuis le dashboard admin.
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();

        // Hash du mot de passe
        $data['password'] = Hash::make($data['password']);

        // Si rôle non défini, par défaut user
        if (!isset($data['role'])) {
            $data['role'] = 'user';
        }

        User::create($data);

        return redirect()->back()->with('success', 'Utilisateur créé avec succès');
    }

    /**
     * Retourne les infos de l’utilisateur connecté (API).
     */
    public function user()
    {
        return response()->json(Auth::user());
    }

    /**
     * Limitation optionnelle des tentatives de connexion.
     */
    // protected function validateLoginAttempts(Request $request)
    // {
    //     $this->middleware('throttle:5,1'); // max 5 tentatives / 1 minute
    // }
}
