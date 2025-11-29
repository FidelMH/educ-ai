# Chatbot Implementation Sprint Plan

This document outlines the development plan for implementing the chatbot feature, structured as a single sprint with actionable code examples for Laravel 12.

---

### **Sprint Goal**
Implement a fully functional, asynchronous chatbot prototype that securely connects to the Groq API and handles user interactions via a background queue system.

---

### **Product Backlog & Tasks**

#### **Backlog Item 1: Environment and API Configuration**
*As a developer, I want to configure the Laravel application to securely connect to the Groq API and handle background tasks, so that the project is ready for chatbot feature development.*

**Tasks:**
1.  **Install HTTP Client:**
    *   Run: `composer require openai-php/laravel`
2.  **Configure API Key:**
    *   Add the following line to your `.env` file:
        ```env
        GROQ_API_KEY="your-key-here"
        ```
3.  **Publish and Configure Service:**
    *   First, publish the configuration file:
        ```shell
        php artisan vendor:publish --provider="OpenAI\Laravel\ServiceProvider"
        ```
    *   Then, modify the newly created `config/openai.php` file:
        ```php
        <?php
        
        return [
            'api_key' => env('GROQ_API_KEY'),
            'organization' => env('OPENAI_ORGANIZATION'),
            'base_uri' => 'api.groq.com/openai/v1', // Point to Groq's endpoint
        ];
        ```
4.  **Configure Queue System:**
    *   In your `.env` file, set the queue driver to `database`:
        ```env
        QUEUE_CONNECTION=database
        ```
5.  **Create Jobs Table:**
    *   Generate the migration for the jobs table:
        ```shell
        php artisan queue:table
        ```
    *   Run the migration to create the table in your database:
        ```shell
        php artisan migrate
        ```

---

#### **Backlog Item 2: Core Chatbot Logic (Background Job)**
*As a user, I want the system to process my message, generate an AI response based on my profile and conversation history, and save it, so that I can have a meaningful conversation with the chatbot.*

**Tasks:**
1.  **Create Job Class:**
    *   Run: `php artisan make:job ProcessChatbotResponse`
2.  **Implement the Job:**
    *   Replace the entire content of `app/Jobs/ProcessChatbotResponse.php` with the following code. This job will handle all communication with the Groq API.
        ```php
        <?php

        namespace App\Jobs;

        use App\Models\Discuss;
        use App\Models\Message;
        use Illuminate\Bus\Queueable;
        use Illuminate\Contracts\Queue\ShouldQueue;
        use Illuminate\Foundation\Bus\Dispatchable;
        use Illuminate\Queue\InteractsWithQueue;
        use Illuminate\Queue\SerializesModels;
        use Illuminate\Support\Facades\Log;
        use OpenAI;

        class ProcessChatbotResponse implements ShouldQueue
        {
            use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

            protected Discuss $discuss;

            public function __construct(Discuss $discuss)
            {
                $this->discuss = $discuss;
            }

            public function handle(): void
            {
                $client = OpenAI::client();
                
                $agent = $this->discuss->agent;
                $user = $this->discuss->user;
                $level = $user->level->level;

                $systemPrompt = $agent->prompt . " Ton explication doit être adaptée pour un utilisateur de niveau : {$level}.";
                
                $messages = $this->discuss->messages()->latest()->limit(10)->get()->reverse();
                $history = [];
                foreach ($messages as $message) {
                    $role = $message->is_user ? 'user' : 'assistant';
                    $history[] = ['role' => $role, 'content' => $message->content];
                }

                try {
                    $response = $client->chat()->create([
                        'model' => 'llama3-8b-8192',
                        'messages' => array_merge(
                            [['role' => 'system', 'content' => $systemPrompt]],
                            $history
                        ),
                    ]);

                    $aiResponseContent = $response->choices[0]->message->content;

                    Message::create([
                        'discuss_id' => $this->discuss->id,
                        'content' => $aiResponseContent,
                        'is_user' => false,
                    ]);

                } catch (\Exception $e) {
                    Log::error('Groq API call failed: ' . $e->getMessage());
                    Message::create([
                        'discuss_id' => $this->discuss->id,
                        'content' => "Désolé, une erreur s'est produite. Veuillez réessayer.",
                        'is_user' => false,
                    ]);
                }
            }
        }
        ```

---

#### **Backlog Item 3: User Interaction (Controller Logic)**
*As a user, I want to be able to submit my message through the chat interface and have it processed correctly, so that I can interact with the chatbot.*

**Tasks:**
1.  **Implement the Controller Method:**
    *   Replace the `store` method in `app/Http/Controllers/MessagesController.php` with the following. This method validates the request, saves the user's message, and dispatches the job to the queue.
        ```php
        <?php

        namespace App\Http\Controllers;

        use App\Jobs\ProcessChatbotResponse;
        use App\Models\Discuss;
        use App\Models\Message;
        use Illuminate\Http\Request;

        class MessagesController extends Controller
        {
            public function store(Request $request)
            {
                $validated = $request->validate([
                    'discuss_id' => 'required|exists:discuss,id',
                    'content' => 'required|string|max:4096',
                ]);

                $discussion = Discuss::findOrFail($validated['discuss_id']);
                
                if ($discussion->user_id !== auth()->id()) {
                    abort(403, 'Unauthorized action.');
                }

                Message::create([
                    'discuss_id' => $discussion->id,
                    'content' => $validated['content'],
                    'is_user' => true,
                ]);

                ProcessChatbotResponse::dispatch($discussion);

                return redirect()->route('dashboard.discuss.show', $discussion);
            }
        }
        ```
    *   *Note: Make sure the other methods in the controller are empty or removed if not used.*

---

### **Execution Note: Running the Queue Worker**

For the chatbot to reply, the queue worker must be running. This process executes the background jobs.

*   **Action:** Run the following command in your terminal and keep it active during development.
    ```shell
    php artisan queue:work
    ```
