<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Affiche une liste de la ressource.
     */
    public function index()
    {
        // Précharge la relation users pour éviter le problème N+1
        $roles = Role::withCount('users')->latest()->paginate(10);

        return view('roles.index', compact('roles'));
    }

    /**
     * Affiche le formulaire pour créer une nouvelle ressource.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Stocke une nouvelle ressource dans la base de données (CREATE).
     */
    public function store(Request $request)
    {
        // 1. Validation des données
        $request->validate([
            'role' => 'required|string|max:255|unique:roles,role',
        ], [
            'role.required' => 'Le nom du rôle est obligatoire.',
            'role.unique' => 'Ce rôle existe déjà.',
            'role.max' => 'Le nom du rôle ne peut pas dépasser 255 caractères.',
        ]);

        // 2. Création de l'enregistrement
        Role::create([
            'role' => $request->input('role'),
        ]);

        // 3. Redirection
        return redirect()->route('roles.index')
                         ->with('success', 'Rôle créé avec succès.');
    }

    /**
     * Affiche la ressource spécifiée (READ ONE).
     */
    public function show(Role $role) // Route Model Binding
    {
        // Charge la relation users pour l'affichage détaillé
        $role->load('users');

        return view('roles.show', compact('role'));
    }

    /**
     * Affiche le formulaire pour éditer la ressource spécifiée.
     */
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    /**
     * Met à jour la ressource spécifiée dans la base de données (UPDATE).
     */
    public function update(Request $request, Role $role)
    {
        // 1. Validation des données (ignore le rôle actuel pour la règle unique)
        $request->validate([
            'role' => 'required|string|max:255|unique:roles,role,' . $role->id,
        ], [
            'role.required' => 'Le nom du rôle est obligatoire.',
            'role.unique' => 'Ce rôle existe déjà.',
            'role.max' => 'Le nom du rôle ne peut pas dépasser 255 caractères.',
        ]);

        // 2. Mise à jour de l'enregistrement
        $role->update([
            'role' => $request->input('role'),
        ]);

        // 3. Redirection
        return redirect()->route('roles.index')
                         ->with('success', 'Rôle mis à jour avec succès.');
    }

    /**
     * Supprime la ressource spécifiée de la base de données (DELETE).
     */
    public function destroy(Role $role)
    {
        // Vérification de sécurité : empêcher la suppression si des utilisateurs sont associés
        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')
                             ->with('error', 'Impossible de supprimer ce rôle car des utilisateurs y sont associés.');
        }

        $role->delete();

        return redirect()->route('roles.index')
                         ->with('success', 'Rôle supprimé avec succès.');
    }
}
