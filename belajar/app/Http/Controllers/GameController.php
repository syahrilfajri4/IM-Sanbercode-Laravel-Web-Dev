<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GameController extends Controller
{
    public function create()
    {
        return view('games.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5',
            'developer' => 'required',
            'year'  => 'required',
            'game_play' => 'required',
        ]);

        DB::table('tablegames')->insert([
            'name' => $request->input('name'),
            'developer' => $request->input('developer'),
            'year'  => $request->input('year'),
            'game_play' => $request->input('game_play'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return redirect('/games');
    }

    public function edit($id)
    {
        $games = DB::table('tablegames')->find($id);

        return view('tablegames.edit', ['tablegames' => $games]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'developer' => 'required|string|max:255',
            'year' => 'required|integer',
            'game_play' => 'required|integer',
        ]);

        DB::table('tablegames')
            ->where('id', $id)
            ->update(
                [
                    'name' => $request->input("name"),
                    'developer' => $request->input("developer"),
                    'year' => $request->input("year"),
                    'game_play' => $request->input("game_play"),
                    'updated_at' => Carbon::now(),
                ]
            );

        return redirect("/games");
    }

    public function show($id)
    {
        $game = DB::table('tablegames')->find($id);
        return view('games.show', compact('game'));
    }
}
