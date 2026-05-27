<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        // Rate limiting : max 5 tentatives / minute par IP + email
        $key = 'login.' . Str::lower($request->input('email')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => "Trop de tentatives. Réessaie dans {$seconds} secondes.",
            ])->onlyInput('email');
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::clear($key);
            $request->session()->regenerate();

            $user  = Auth::user();
            $flash = ['show_curtain' => true];

            // Détecter une invitation en attente sur cet email
            $invitation = Invitation::where('email', Str::lower($user->email))
                ->orWhere('email', $user->email)
                ->where('accepte', false)
                ->with('user')
                ->first();

            if ($invitation) {
                $invitation->update(['accepte' => true]);
                $flash['invited_by']      = $invitation->user->firstname . ' ' . $invitation->user->lastname;
                $flash['invited_message'] = $invitation->message ?? null;
            }

            return redirect()->intended(route('home'))->with($flash);
        }

        RateLimiter::hit($key, 60);

        return back()->withErrors([
            'email' => 'Les informations de connexion sont incorrectes.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('home'))->with('success', 'Vous avez été déconnecté.');
    }
}
