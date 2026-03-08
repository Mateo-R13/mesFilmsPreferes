<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        // 🔒 Hash sécurisé via Hash::make (bcrypt avec cost factor)
        $user = User::create([
            'firstname' => strip_tags($request->firstname),
            'lastname'  => strip_tags($request->lastname),
            'username'  => strip_tags($request->username),
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect(route('home'))
            ->with('success', 'Compte créé avec succès ! Bienvenue ' . e($user->username) . ' 🎬');
    }
}
