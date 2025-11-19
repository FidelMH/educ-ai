<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Level;
use App\Models\Subject;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    /**
     * Affiche une liste de la ressource.
     */
    public function index()
    {
        // Précharge les relations pour éviter le problème N+1
        $agents = Agent::with(['level', 'subject'])->latest()->paginate(10); 

        return view('agents.index', compact('agents'));
    }



    /**
     * Affiche le formulaire pour créer une nouvelle ressource.
     */
    public function create()
    {
        // Récupère les données nécessaires pour les listes déroulantes du formulaire
        $levels = Level::all();
        $subjects = Subject::all();

        return view('agents.create', compact('levels', 'subjects'));
    }


    /**
     * Stocke une nouvelle ressource dans la base de données (CREATE).
     */
    public function store(Request $request)
    {
        // 1. Validation des données
        $request->validate([
            'prompt' => 'required|string|max:2000',
            // Clés étrangères : doivent exister dans leurs tables respectives
            'level_id' => 'required|exists:levels,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);
        
        // Les relations hasOne (level et subject) doivent être gérées via des clés étrangères 
        // dans la table 'agents', ou si ces clés sont dans les tables 'levels'/'subjects', 
        // vous devez gérer leur création/association séparément. 
        // Si les clés sont dans 'agents', le code est simple :
        
        // 2. Création de l'enregistrement
        $agent = Agent::create([
            'prompt' => $request->input('prompt'),
            'level_id' => $request->input('level_id'), // Supposant que agent a un level_id/subject_id
            'subject_id' => $request->input('subject_id'), // dans sa propre table.
        ]);
        
        // *NOTE IMPORTANTE sur les relations HasOne/BelongsTo :*
        // Pour que hasOne fonctionne comme vous l'avez défini, les tables 'levels' et 'subjects' 
        // devraient avoir une colonne 'agent_id'. Cependant, en CRUD, il est plus courant 
        // que l'entité qui possède la clé étrangère soit le 'belongsTo'.
        // J'ai supposé que vous gériez les IDs directement dans la table `agents`.

        // 3. Redirection
        return redirect()->route('agents.index')
                         ->with('success', 'Agent créé avec succès.');
    }


    /**
     * Affiche la ressource spécifiée (READ ONE).
     */
    public function show(Agent $agent) // Route Model Binding
    {
        // Charge les relations pour l'affichage détaillé
        $agent->load(['level', 'subject']);
        
        return view('agents.show', compact('agent'));
    }



    /**
     * Affiche le formulaire pour éditer la ressource spécifiée.
     */
    public function edit(Agent $agent)
    {
        // Récupère les listes pour les sélecteurs
        $levels = Level::all();
        $subjects = Subject::all();
        
        return view('agents.edit', compact('agent', 'levels', 'subjects'));
    }



    /**
     * Met à jour la ressource spécifiée dans la base de données (UPDATE).
     */
    public function update(Request $request, Agent $agent)
    {
        // 1. Validation des données
        $request->validate([
            'prompt' => 'required|string|max:2000',
            'level_id' => 'required|exists:levels,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        // 2. Mise à jour de l'enregistrement
        $agent->update([
            'prompt' => $request->input('prompt'),
            'level_id' => $request->input('level_id'),
            'subject_id' => $request->input('subject_id'),
        ]);

        // 3. Redirection
        return redirect()->route('agents.index')
                         ->with('success', 'Agent mis à jour avec succès.');
    }



    /**
     * Supprime la ressource spécifiée de la base de données (DELETE).
     */
    public function destroy(Agent $agent)
    {
        $agent->delete();

        return redirect()->route('agents.index')
                         ->with('success', 'Agent supprimé avec succès.');
    }
}