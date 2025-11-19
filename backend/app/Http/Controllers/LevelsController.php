<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;

class LevelsController extends Controller
{
    /**
     * Affiche une liste de la ressource.
     */
    public function index()
    {
        // Précharge la relation agents pour éviter le problème N+1
        $levels = Level::withCount('users')->latest()->paginate(10);

        return view('levels.index', compact('levels'));
    }

    /**
     * Affiche le formulaire pour créer une nouvelle ressource.
     */
    public function create()
    {
        return view('levels.create');
    }

    /**
     * Stocke une nouvelle ressource dans la base de données (CREATE).
     */
    public function store(Request $request)
    {
        // 1. Validation des données
        $request->validate([
            'level' => 'required|string|max:255',
            'description' => 'required|string|max:500',
        ], [
            'level.required' => 'Le nom du niveau est obligatoire.',
            'level.max' => 'Le nom du niveau ne peut pas dépasser 255 caractères.',
            'description.required' => 'La description est obligatoire.',
            'description.max' => 'La description ne peut pas dépasser 500 caractères.',
        ]);

        // 2. Création de l'enregistrement
        Level::create([
            'level' => $request->input('level'),
            'description' => $request->input('description'),
        ]);

        // 3. Redirection
        return redirect()->route('levels.index')
                         ->with('success', 'Niveau créé avec succès.');
    }

    /**
     * Affiche la ressource spécifiée (READ ONE).
     */
    public function show(Level $level) // Route Model Binding
    {
        // Charge la relation agents pour l'affichage détaillé
        $level->load('users');

        return view('levels.show', compact('level'));
    }

    /**
     * Affiche le formulaire pour éditer la ressource spécifiée.
     */
    public function edit(Level $level)
    {
        return view('levels.edit', compact('level'));
    }

    /**
     * Met à jour la ressource spécifiée dans la base de données (UPDATE).
     */
    public function update(Request $request, Level $level)
    {
        // 1. Validation des données
        $request->validate([
            'level' => 'required|string|max:255',
            'description' => 'required|string|max:500',
        ], [
            'level.required' => 'Le nom du niveau est obligatoire.',
            'level.max' => 'Le nom du niveau ne peut pas dépasser 255 caractères.',
            'description.required' => 'La description est obligatoire.',
            'description.max' => 'La description ne peut pas dépasser 500 caractères.',
        ]);

        // 2. Mise à jour de l'enregistrement
        $level->update([
            'level' => $request->input('level'),
            'description' => $request->input('description'),
        ]);

        // 3. Redirection
        return redirect()->route('levels.index')
                         ->with('success', 'Niveau mis à jour avec succès.');
    }

    /**
     * Supprime la ressource spécifiée de la base de données (DELETE).
     */
    public function destroy(Level $level)
    {
        // Vérification de sécurité : empêcher la suppression si des utilisateurs sont associés
        if ($level->users()->count() > 0) {
            return redirect()->route('levels.index')
                             ->with('error', 'Impossible de supprimer ce niveau car des utilisateurs y sont associés.');
        }

        $level->delete();

        return redirect()->route('levels.index')
                         ->with('success', 'Niveau supprimé avec succès.');
    }
}
