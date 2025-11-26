<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UsersController extends Controller
{
    /**
     * Affiche une liste de la ressource.
     */
    public function index()
    {
        // Précharge la relation role pour éviter le problème N+1
        $users = User::with('role')->latest()->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Affiche le formulaire pour créer une nouvelle ressource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Stocke une nouvelle ressource dans la base de données (CREATE).
     */
    public function store(Request $request)
    {
        // 1. Validation des données
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roles_id' => 'required|exists:roles,id',
            'consentement' => 'boolean',
        ], [
            'firstname.required' => 'Le prénom est obligatoire.',
            'lastname.required' => 'Le nom est obligatoire.',
            'email.required' => 'L\'email est obligatoire.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'roles_id.required' => 'Le rôle est obligatoire.',
            'roles_id.exists' => 'Le rôle sélectionné n\'existe pas.',
        ]);

        // 2. Création de l'enregistrement
        User::create([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'roles_id' => $request->input('roles_id'),
            'consentement' => $request->has('consentement'),
        ]);

        // 3. Redirection
        return redirect()->route('users.index')
                         ->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Affiche la ressource spécifiée (READ ONE).
     */
    public function show(User $user) // Route Model Binding
    {
        // Charge les relations pour l'affichage détaillé
        $user->load(['role', 'messages',]);

        return view('users.show', compact('user'));
    }

    /**
     * Affiche le formulaire pour éditer la ressource spécifiée.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Met à jour la ressource spécifiée dans la base de données (UPDATE).
     */
    public function update(Request $request, User $user)
    {
        // 1. Validation des données (ignore l'utilisateur actuel pour la règle unique)
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'roles_id' => 'required|exists:roles,id',
            'consentement' => 'boolean',
        ], [
            'firstname.required' => 'Le prénom est obligatoire.',
            'lastname.required' => 'Le nom est obligatoire.',
            'email.required' => 'L\'email est obligatoire.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'roles_id.required' => 'Le rôle est obligatoire.',
            'roles_id.exists' => 'Le rôle sélectionné n\'existe pas.',
        ]);

        // 2. Mise à jour de l'enregistrement
        $data = [
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'roles_id' => $request->input('roles_id'),
            'consentement' => $request->has('consentement'),
        ];

        // Mettre à jour le mot de passe uniquement s'il est fourni
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        $user->update($data);

        // 3. Redirection
        return redirect()->route('users.index')
                         ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Supprime la ressource spécifiée de la base de données (DELETE).
     */
    public function destroy(User $user)
    {
        // Empêcher la suppression de son propre compte
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                             ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('users.index')
                         ->with('success', 'Utilisateur supprimé avec succès.');
    }
}
