<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationsController extends Controller
{
    public function index()
    {
        $invitations = Invitation::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('invitations.index', compact('invitations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'     => ['required', 'string', 'max:100'],
            'prenom'  => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email:rfc', 'max:255'],
            'message' => ['nullable', 'string', 'max:500'],
        ]);

        // Vérification anti-doublon : l'utilisateur n'a pas déjà invité cet email
        $dejaInvite = Invitation::where('user_id', Auth::id())
            ->where('email', $request->email)
            ->exists();

        if ($dejaInvite) {
            return back()->withErrors(['email' => 'Tu as déjà envoyé une invitation à cette adresse email.'])->withInput();
        }

        Invitation::create([
            'user_id' => Auth::id(),
            'nom'     => strip_tags($request->nom),
            'prenom'  => strip_tags($request->prenom),
            'email'   => $request->email,
            'message' => $request->filled('message') ? strip_tags($request->message) : null,
            'accepte' => false,
        ]);

        return redirect()->route('invitations')->with('success', 'Invitation envoyée à ' . e($request->prenom) . ' ' . e($request->nom) . ' !');
    }
}
