<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Level;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
// use App\Http\Controllers\LoginController;

class RegisterController extends Controller
{
    public function create(): View
    {
        $levels = Level::orderBy('level', 'asc')->get();
        return view('auth.register', compact('levels'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'lastname' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'level_id' => ['required', 'exists:levels,id'],
            'consentement' => ['required', 'accepted'], // doit être coché
        ]);

        // Récupérer l'ID du rôle "user"
        $userRole = Role::where('role', 'user')->first();

        if (!$userRole) {
            return back()->withErrors([
                'error' => 'Le rôle par défaut n\'existe pas. Veuillez contacter l\'administrateur.'
            ]);
        }

        $user = User::create([
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level_id' => $request->level_id,
            'roles_id' => $userRole->id,
            'consentement' => true,
        ]);

        event(new Registered($user));

        auth()->login($user);

        return redirect()->route('chat');
    }
}