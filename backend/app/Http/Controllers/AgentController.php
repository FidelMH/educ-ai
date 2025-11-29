<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load the subject for each agent
        $agents = Agent::with('subject')->latest()->paginate(10);
        return view('agents.index', compact('agents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Find subjects that do not already have an agent
        $subjectsWithoutAgent = Subject::whereDoesntHave('agent')->get();
        
        if ($subjectsWithoutAgent->isEmpty()) {
            return redirect()->route('agents.index')->with('info', 'Toutes les matières ont déjà un agent configuré.');
        }

        return view('agents.create', compact('subjectsWithoutAgent'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => [
                'required',
                'exists:subjects,id',
                Rule::unique('agents', 'subject_id'),
            ],
            'prompt' => 'required|string|max:2000',
        ]);

        Agent::create($request->all());

        return redirect()->route('agents.index')
                         ->with('success', 'Agent créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Agent $agent)
    {
        $agent->load('subject');
        return view('agents.show', compact('agent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agent $agent)
    {
        // In this new design, you're just editing the prompt for the agent's existing subject.
        return view('agents.edit', compact('agent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agent $agent)
    {
        $request->validate([
            'prompt' => 'required|string|max:2000',
        ]);

        $agent->update($request->only('prompt'));

        return redirect()->route('agents.index')
                         ->with('success', 'Prompt de l\'agent mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agent $agent)
    {
        $agent->delete();

        return redirect()->route('agents.index')
                         ->with('success', 'Agent supprimé avec succès.');
    }
}
