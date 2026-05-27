<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'firstname' => ['required', 'string', 'max:100', 'regex:/^[\p{L}\s\-\']+$/u'],
            'lastname'  => ['required', 'string', 'max:100', 'regex:/^[\p{L}\s\-\']+$/u'],
            'username'  => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z0-9_\.\-]+$/', 'unique:users'],
            'email'     => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users'],
            'password'  => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
        ]);

        $user = User::create([
            'firstname' => strip_tags($request->firstname),
            'lastname'  => strip_tags($request->lastname),
            'username'  => strip_tags($request->username),
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        Auth::login($user);

        $flash = ['show_curtain' => true];

        // Détecter une invitation en attente sur cet email (insensible à la casse)
        $invitation = Invitation::whereRaw('LOWER(email) = ?', [Str::lower($user->email)])
            ->where('accepte', false)
            ->with('user')
            ->first();

        if ($invitation) {
            $invitation->update(['accepte' => true]);
            $flash['invited_by']      = $invitation->user->firstname . ' ' . $invitation->user->lastname;
            $flash['invited_message'] = $invitation->message ?? null;
        }

        return redirect(route('home'))->with($flash);
    }
}
