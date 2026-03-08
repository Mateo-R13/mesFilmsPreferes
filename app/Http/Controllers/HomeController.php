<?php

namespace App\Http\Controllers;

use App\Models\Ami;
use App\Models\Favori;
use App\Models\Partage;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $stats = null;

        if (Auth::check()) {
            $userId = Auth::id();
            $stats = [
                'favoris'  => Favori::where('user_id', $userId)->count(),
                'amis'     => Ami::where('user_id', $userId)->count(),
                'envoyes'  => Partage::where('user_id', $userId)->count(),
                'recus'    => Partage::where('ami_id', $userId)->count(),
            ];
        }

        return view('home.index', compact('stats'));
    }
}
