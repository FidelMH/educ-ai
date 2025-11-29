# Chatbot Development Plan

## 1. Project Overview & Context

**Objective:** Implement a multi-conversation chat interface for end-users. Users will be able to start conversations with different "Agents," each specialized in a specific "Subject" (e.g., Math, History).

**Core Functionality:**
- Users can see a list of their past conversations.
- Users can start a new conversation by choosing an Agent.
- Users can delete their conversations.
- Inside a conversation, users can exchange messages with the AI agent.

**Technical Architecture:**
- **Backend:** Laravel 12. A new `ChatController` will be created to handle all user-facing logic, keeping it separate from the existing `DiscussController` which is used for the admin panel.
- **Models:** The existing Eloquent models will be leveraged:
    - `User`: The authenticated user.
    - `Agent`: The AI persona, linked to a `Subject`.
    - `Subject`: The area of expertise for an Agent.
    - `Discuss`: Represents a single conversation thread.
    - `Message`: Represents a single message within a `Discuss`.
- **AI Integration:** The `openai-php` package will communicate with the Groq API. All AI-related configuration (API Key, Base URI) is managed in a dedicated configuration file (e.g., `config/openai.php`) and the `.env` file.

---

## 2. Phase 1: Foundation (Sequential Tasks)

*This phase is a prerequisite and must be completed before starting the parallel tracks. It ensures the core structure is in place.*

**Task 1.1: Add `user_id` to Discussions Table**
- **Action:**
    1. Generate a new migration: `php artisan make:migration add_user_id_to_discusses_table --table=discusses`
    2. In the generated migration file, within the `up()` method, add:
       `$table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');`
    3. Run the migration: `php artisan migrate`
- **Reason:** This is a critical security and data integrity step. It ensures that each conversation belongs to a specific user. `onDelete('cascade')` automatically cleans up a user's conversations if their account is deleted. We use `nullable()` for existing discussions that might not have a user.

**Task 1.2: Update Model Relationships**
- **Action:**
    - In `app/Models/User.php`, add the `hasMany` relationship:
      ```php
      public function discusses()
      {
          return $this->hasMany(\App\Models\Discuss::class);
      }
      ```
    - In `app/Models/Discuss.php`, add the `belongsTo` relationship:
      ```php
      public function user()
      {
          return $this->belongsTo(\App\Models\User::class);
      }
      ```
- **Reason:** This defines the Eloquent relationship, making it trivial to fetch a user's conversations (e.g., `auth()->user()->discussions`) and the owner of a discussion.

**Task 1.3: Create `ChatController`**
- **Action:** Run `php artisan make:controller ChatController`
- **Reason:** To establish a dedicated controller for all user-facing chat logic, separating it from the admin-focused `DiscussController`.

**Task 1.4: Define User-Facing Routes**
- **Action:** Add the following route group to `routes/web.php`. It should be placed inside the main `auth` middleware group, but outside the `admin` one.
    ```php
    use App\Http\Controllers\ChatController;

    /*
    |--------------------------------------------------------------------------
    | User-Facing Chat Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('chat')->name('chat.')->middleware('auth')->group(function () {
        Route::get('/', [ChatController::class, 'index'])->name('index'); // List conversations
        Route::get('/create', [ChatController::class, 'create'])->name('create'); // Show form to create
        Route::post('/', [ChatController::class, 'store'])->name('store'); // Store new conversation
        Route::get('/{discuss}', [ChatController::class, 'show'])->name('show'); // Show a specific conversation
        Route::delete('/{discuss}', [ChatController::class, 'destroy'])->name('destroy'); // Delete a conversation
        Route::post('/{discuss}/message', [ChatController::class, 'message'])->name('message'); // Send a message
    });
    ```
- **Reason:** These routes provide all necessary endpoints for the feature. Grouping them under a prefix and name improves organization and clarity.

---

## 3. Phase 2: Parallel Development

*Once Phase 1 is complete, two developers can work on these tracks simultaneously.*

### **Track A: Backend Development (Developer 1)**

**Objective:** Implement the complete server-side logic that powers the chat functionality.

**Task A.1: Implement `ChatController` (CRUD actions)**
- **`index()`:** Fetch all discussions for the authenticated user: `auth()->user()->discussions()->with('agent.subject')->latest()->get()`. Pass this data to a new view `resources/views/chat/index.blade.php`.
- **`create()`:** Fetch all `Agent` models: `\App\Models\Agent::with('subject')->get()`. Pass them to a new view `resources/views/chat/create.blade.php`.
- **`store(Request $request)`:**
    - Validate the incoming `agent_id` (`required|exists:agents,id`).
    - Create a new `\App\Models\Discuss` record: `auth()->user()->discussions()->create(['agent_id' => $request->agent_id]);`
    - Redirect to the `chat.show` route for the newly created discussion.
- **`show(Discuss $discuss)`:**
    - **Authorization:** Ensure the user owns the discussion: `if ($discuss->user_id !== auth()->id()) { abort(403); }`.
    - Load the discussion's messages: `$discuss->load('messages', 'agent.subject')`.
    - Pass the `$discuss` object to the `resources/views/chat/show.blade.php` view.
- **`destroy(Discuss $discuss)`:**
    - Perform the same authorization check as `show()`.
    - Delete the discussion: `$discuss->delete()`.
    - Redirect to `chat.index` with a success message.

**Task A.2: Implement `ChatController::message()` (Core AI Logic)**
- **Objective:** Handle the AJAX request to send a user message and get an AI response.
- **Steps:**
    1. **Authorization:** Check if `auth()->id()` matches `$discuss->user_id`.
    2. **Validation:** Validate the incoming request has a non-empty `message` field.
    3. **Persist User Message:** Save the user's message: `$discuss->messages()->create(['message' => $request->message, 'user_id' => auth()->id(), 'type_message' => 'user']);`
    4. **Prepare AI Context:**
        - Create a system prompt: `['role' => 'system', 'content' => "You are an expert in {$discuss->agent->subject->name}."]`.
        - Fetch all messages for the discussion, ordered by date.
        - Map these messages into the `['role' => '...', 'content' => '...']` format required by the API. The role should be `'assistant'` if `user_id` is null, and `'user'` otherwise (or use `type_message`).
    5. **Call Groq API:**
        - Instantiate the client using your existing configuration for Groq.
        - Make the API call: `$response = $client->chat()->create(['model' => 'llama3-8b-8192', 'messages' => $formattedMessages]);`
    6. **Persist AI Message:** Save the response content as a new `Message` with `type_message` = `'assistant'`.
    7. **Return JSON:** Return the newly created assistant message as a JSON object: `return response()->json($assistantMessage);`.

**Task A.3: Create `DiscussPolicy` for Authorization**
- **Action:**
    - Run `php artisan make:policy DiscussPolicy --model=Discuss`.
    - In `DiscussPolicy`, implement `view`, `delete`, etc., with the logic: `return $user->id === $discuss->user_id;`.
    - Register the policy in `app/Providers/AuthServiceProvider.php`.
    - In `ChatController`, replace manual `abort(403)` checks with `$this->authorize('view', $discuss);`.
- **Reason:** Centralizes authorization logic, making the controller cleaner and more secure.

### **Track B: Frontend Development (Developer 2)**

**Objective:** Build the complete user interface for the chat feature.

**Task B.1: Create List and "New Conversation" Views**
- **File:** `resources/views/chat/index.blade.php`
    - **Content:** Display the list of conversations passed from the controller. Each item should show the agent's subject and last activity time, and link to the `chat.show` route. Add a "Delete" button (in a `<form>`) for each. Include a "Start New Conversation" button linking to `chat.create`.
- **File:** `resources/views/chat/create.blade.php`
    - **Content:** A simple form submitting to `chat.store`. It must contain a `<select>` dropdown populated with the agents passed from the controller, showing the agent's name and subject.

**Task B.2: Build the Main Chat Interface View**
- **File:** `resources/views/chat/show.blade.php`
- **HTML Structure:**
    - A header displaying the Agent's name and subject specialization.
    - A scrollable container (`<div id="chat-messages">`) for the message history.
    - Inside, loop through `$discuss->messages` and display each one. Use Blade conditionals (`@if`) on `message->type_message` to apply different CSS classes for "user" and "assistant" messages (e.g., different background colors, alignment).
    - At the bottom, a `<form id="message-form">` with a text input, a submit button, and the `@csrf` directive.

**Task B.3: Implement JavaScript for Dynamic Chat**
- **Location:** In a `<script>` tag at the bottom of `chat.show.blade.php`.
- **Logic:**
    1. Listen for the `submit` event on `#message-form`.
    2. Call `event.preventDefault()` to stop the page from reloading.
    3. Get the message from the input field. If empty, do nothing.
    4. **Optimistic UI:** Create a new DOM element for the user's message and append it to the `#chat-messages` container. Clear the input field.
    5. Use the `fetch` API to send a `POST` request to the `chat.message` route for the current discussion.
        - Include the `X-CSRF-TOKEN` in the headers.
        - Send the message content as JSON in the request body.
    6. **Handle Response:** On a successful response, parse the JSON, create a new DOM element for the AI's message, and append it to the chat container.
    7. **UX:** Implement auto-scrolling to the latest message. Add a visual "typing..." indicator while waiting for the `fetch` request to complete.
    8. **Error Handling:** Display a user-friendly error message if the `fetch` call fails.

