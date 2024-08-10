<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kritik;

class KritikController extends Controller
{
    public function store(Request $request, $film_id)
    {
        $request->validate([
            'content' => 'required|min:5',
            'point'   => 'required'
        ]);

        $userid = Auth::id();

        $kritik = new Kritik;

        $kritik->content = $request->input('content');
        $kritik->point = $request->input('point');
        $kritik->user_id = $userid;
        $kritik->film_id = $film_id;

        $kritik->save();

        return redirect('/film/' . $film_id);
    }
}
