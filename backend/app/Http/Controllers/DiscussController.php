<?php

namespace App\Http\Controllers;

use App\Models\Discuss;
use App\Models\Agent;
use Illuminate\Http\Request;

class DiscussController extends Controller
{
    /**
     * Affiche la liste des discussions (Admin Style).
     */
    public function index()
    {
        // On charge 'agent' et 'agent.subject' pour afficher les infos dans le tableau
        $discusses = Discuss::with(['agent.subject'])->latest()->paginate(10);

        return view('discuss.index', compact('discusses'));
    }

    /**
     * Formulaire de création (Admin Style).
     */
    public function create()
    {
        $agents = Agent::with('subject')->get(); // Pour le menu déroulant
        return view('discuss.create', compact('agents'));
    }

    /**
     * Enregistre la discussion.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'agent_id' => 'required|exists:agents,id',
        ]);

        $discuss = Discuss::create($validated);

        return redirect()->route('discuss.show', $discuss)
                         ->with('success', 'Discussion initialisée avec succès.');
    }

    /**
     * Affiche la discussion (Interface de Chat Admin).
     */
    public function show(Discuss $discuss)
    {
        $discuss->load(['agent', 'messages']); // Charge l'historique
        return view('discuss.show', compact('discuss'));
    }

    /**
     * Formulaire d'édition.
     */
    public function edit(Discuss $discuss)
    {
        $agents = Agent::with('subject')->get();
        return view('discuss.edit', compact('discuss', 'agents'));
    }

    /**
     * Mise à jour.
     */
    public function update(Request $request, Discuss $discuss)
    {
        $validated = $request->validate([
            'agent_id' => 'required|exists:agents,id',
        ]);

        $discuss->update($validated);

        return redirect()->route('discuss.index')
                         ->with('success', 'Discussion mise à jour.');
    }

    /**
     * Suppression.
     */
    public function destroy(Discuss $discuss)
    {
        $discuss->delete();

        return redirect()->route('discuss.index')
                         ->with('success', 'Discussion supprimée.');
    }
}