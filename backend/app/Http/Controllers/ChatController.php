<?php

namespace App\Http\Controllers;

use App\Models\Discuss;
use App\Models\Agent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display the chat interface with sidebar and active conversation.
     */
    public function index(Discuss $discuss = null)
    {
        // Get all user's conversations
        $discusses = auth()->user()
            ->discusses()
            ->with('agent.subject')
            ->latest()
            ->get();

        // Get all available agents
        $agents = Agent::with('subject')->get();

        // If a specific discussion is selected, load it with messages
        $activeDiscuss = null;
        if ($discuss && $discuss->user_id === auth()->id()) {
            $activeDiscuss = $discuss;
            $activeDiscuss->load('messages', 'agent.subject');
        }

        return view('chat', compact('discusses', 'agents', 'activeDiscuss'));
    }

    /**
     * Create a new conversation.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'agent_id' => 'required|exists:agents,id',
        ]);

        $discuss = auth()->user()->discusses()->create($validated);

        return redirect()->route('chat', $discuss->id)
                         ->with('success', 'Nouvelle conversation créée.');
    }

    /**
     * Delete a conversation.
     */
    public function destroy(Discuss $discuss)
    {
        // Authorization
        if ($discuss->user_id !== auth()->id()) {
            abort(403);
        }

        $discuss->delete();

        return redirect()->route('chat')
                         ->with('success', 'Conversation supprimée.');
    }

    /**
     * Handle sending a message and getting AI response.
     */
    public function message(Request $request, Discuss $discuss)
    {
        // Authorization
        if ($discuss->user_id !== auth()->id()) {
            abort(403);
        }

        // Validation
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Save user message
        $userMessage = $discuss->messages()->create([
            'message' => $validated['message'],
            'user_id' => auth()->id(),
            'type_message' => 'user',
            'agent_id' => $discuss->agent_id,
        ]);

        try {
            // Prepare AI context
            $discuss->load('agent.subject', 'messages');

            // Get user's school level
            $user = auth()->user();
            $user->load('level');

            // Start with the agent's system prompt
            $systemPrompt = $discuss->agent->prompt ?? "Tu es un assistant éducatif. Aide l'étudiant à comprendre les concepts de manière claire et pédagogique.";

            // Add user's school level information if available
            if ($user->level) {
                $systemPrompt .= "\n\nIMPORTANT : L'étudiant est en niveau {$user->level->level}. Adapte tes explications et ton vocabulaire au niveau scolaire de l'étudiant.";
            }

            // Format conversation history for API
            $messages = [
                ['role' => 'system', 'content' => $systemPrompt]
            ];

            // Add message history (limit to last 20 messages for context)
            $historyMessages = $discuss->messages()
                ->orderBy('created_at', 'asc')
                ->take(20)
                ->get();

            foreach ($historyMessages as $msg) {
                $messages[] = [
                    'role' => $msg->type_message === 'user' ? 'user' : 'assistant',
                    'content' => $msg->message
                ];
            }

            // Call Groq API using OpenAI client
            $client = \OpenAI::factory()
                ->withApiKey(config('openai.api_key'))
                ->withBaseUri(config('openai.base_uri'))
                ->withHttpClient(new \GuzzleHttp\Client([
                    'verify' => false, // Disable SSL verification for local development
                    'timeout' => config('openai.request_timeout', 30)
                ]))
                ->make();

            $response = $client->chat()->create([
                'model' => 'openai/gpt-oss-20b',
                'messages' => $messages,
                'temperature' => 0.7,
                'max_tokens' => 1000,
            ]);

            // Extract AI response
            $aiResponse = $response->choices[0]->message->content;

            // Save assistant message
            $assistantMessage = $discuss->messages()->create([
                'message' => $aiResponse,
                'type_message' => 'assistant',
                'agent_id' => $discuss->agent_id,
            ]);

            return response()->json([
                'message' => $assistantMessage->message,
                'created_at' => $assistantMessage->created_at->format('H:i'),
            ]);

        } catch (\Exception $e) {
            // Log the error
            \Log::error('Groq API Error: ' . $e->getMessage());

            // Return fallback response
            $fallbackMessage = $discuss->messages()->create([
                'message' => 'Désolé, je rencontre des difficultés techniques. Veuillez réessayer dans quelques instants.',
                'type_message' => 'assistant',
                'agent_id' => $discuss->agent_id,
            ]);

            return response()->json([
                'message' => $fallbackMessage->message,
                'created_at' => $fallbackMessage->created_at->format('H:i'),
            ], 500);
        }
    }
}
