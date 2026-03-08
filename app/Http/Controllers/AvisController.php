<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Favori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvisController extends Controller
{
    public function store(Request $request, Favori $favori)
    {
        if ($favori->user_id !== Auth::id()) abort(403);

        $request->validate([
            'note'        => ['required', 'integer', 'min:1', 'max:5'],
            'commentaire' => ['nullable', 'string', 'max:1000'],
        ]);

        Avis::updateOrCreate(
            ['favori_id' => $favori->id],
            [
                'user_id'     => Auth::id(),
                'note'        => $request->note,
                'commentaire' => $request->commentaire,
            ]
        );

        return back()->with('success', 'Avis enregistré !');
    }

    public function update(Request $request, Avis $avis)
    {
        if ($avis->favori->user_id !== Auth::id()) abort(403);

        $request->validate([
            'note'        => ['required', 'integer', 'min:1', 'max:5'],
            'commentaire' => ['nullable', 'string', 'max:1000'],
        ]);

        $avis->update([
            'note'        => $request->note,
            'commentaire' => $request->commentaire,
        ]);

        return back()->with('success', 'Avis modifié !');
    }

    public function destroy(Avis $avis)
    {
        if ($avis->favori->user_id !== Auth::id()) abort(403);
        $avis->delete();
        return back()->with('success', 'Avis supprimé.');
    }
}
