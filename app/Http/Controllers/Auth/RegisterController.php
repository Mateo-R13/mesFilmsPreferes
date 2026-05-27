<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            'email'     => ['required', 'string', 'email:rfc', 'max:255', 'unique:users'],
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

        // Détecter une invitation en attente (insensible à la casse)
        $invitation = Invitation::whereRaw('LOWER(email) = ?', [Str::lower($user->email)])
            ->where('accepte', false)
            ->with('user')
            ->first();

        if ($invitation && $invitation->user) {
            $inviteur = $invitation->user;
            $now      = now();

            DB::transaction(function () use ($invitation, $inviteur, $user, $now) {
                // Marquer l'invitation comme acceptée
                $invitation->update(['accepte' => true]);

                // Créer l'amitié dans les deux sens (ignoré si déjà existant)
                DB::table('amis')->insertOrIgnore([
                    ['user_id' => $inviteur->id, 'friend_id' => $user->id, 'created_at' => $now, 'updated_at' => $now],
                    ['user_id' => $user->id,     'friend_id' => $inviteur->id, 'created_at' => $now, 'updated_at' => $now],
                ]);
            });

            $flash['invited_by']      = $inviteur->firstname . ' ' . $inviteur->lastname;
            $flash['invited_message'] = $invitation->message ?? null;
        }

        return redirect(route('home'))->with($flash);
    }
}
