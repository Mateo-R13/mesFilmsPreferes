<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'firstname' => ['required','string','max:100','regex:/^[\p{L}\s\-\']+$/u'],
            'lastname'  => ['required','string','max:100','regex:/^[\p{L}\s\-\']+$/u'],
            'username'  => ['required','string','max:50','unique:users','regex:/^[a-zA-Z0-9_\.\-]+$/'],
            'email'     => ['required','email:rfc','max:255','unique:users'],
            'password'  => ['required','string','min:8','max:255','confirmed'],
        ]);

        $user = User::create([
            'firstname' => strip_tags($request->firstname),
            'lastname'  => strip_tags($request->lastname),
            'username'  => strip_tags($request->username),
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('accueil')->with('show_curtain', true);
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('accueil')->with('show_curtain', true);
        }

        return back()->withErrors(['email' => 'Identifiants incorrects.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
