<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Discuss;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * Affiche la liste des messages.
     */
    public function index()
    {
        $messages = Message::with(['user', 'discuss', 'agent'])->latest()->paginate(10);
        return view('messages.index', compact('messages'));
    }

    /**
     * Formulaire de création.
     */
    public function create()
    {
        $discusses = Discuss::with('agent')->get();
        $agents = Agent::all();
        $users = User::all();
        return view('messages.create', compact('discusses', 'agents', 'users'));
    }

    /**
     * Enregistre un nouveau message.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type_message' => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'discuss_id' => 'required|exists:discusses,id',
            'agent_id' => 'required|exists:agents,id',
        ]);

        $message = Message::create($validated);

        return redirect()->route('dashboard.messages.index')
                         ->with('success', 'Message créé avec succès.');
    }

    /**
     * Affiche un message spécifique.
     */
    public function show(Message $message)
    {
        $message->load(['user', 'discuss', 'agent']);
        return view('messages.show', compact('message'));
    }

    /**
     * Formulaire d'édition.
     */
    public function edit(Message $message)
    {
        $discusses = Discuss::with('agent')->get();
        $agents = Agent::all();
        $users = User::all();
        return view('messages.edit', compact('message', 'discusses', 'agents', 'users'));
    }

    /**
     * Mise à jour d'un message.
     */
    public function update(Request $request, Message $message)
    {
        $validated = $request->validate([
            'type_message' => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'discuss_id' => 'required|exists:discusses,id',
            'agent_id' => 'required|exists:agents,id',
        ]);

        $message->update($validated);

        return redirect()->route('dashboard.messages.index')
                         ->with('success', 'Message mis à jour avec succès.');
    }

    /**
     * Suppression d'un message.
     */
    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()->route('dashboard.messages.index')
                         ->with('success', 'Message supprimé avec succès.');
    }
}
