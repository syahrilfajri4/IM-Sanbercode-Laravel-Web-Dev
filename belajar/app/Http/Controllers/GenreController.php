<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Genre;

class GenreController extends Controller
{
    public function create()
    {
        return view('genre.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:5',
            'deskripsi'  => 'required',
        ]);

        DB::table('genre')->insert([
            'nama' => $request->input('nama'),
            'deskripsi'  => $request->input('deskripsi'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return redirect('/genre');
    }

    public function index()
    {
        $genre = DB::table('genre')->get();

        // dd($cast);
        return view('genre.tampil', ['genre' => $genre]);
    }

    public function show($id)
    {
        $genre = Genre::find($id);
        // dd($genre);

        return view('genre.detail', ['genre' => $genre]);
    }

    public function edit($id)
    {
        $genre = DB::table('genre')->find($id);

        return view('genre.edit', ['genre' => $genre]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'nama' => 'required|min:5',
            'deskripsi'  => 'required',
        ]);

        DB::table('genre')
            ->where('id', $id)
            ->update(
                [
                    'nama' => $request->input("nama"),
                    'deskripsi' => $request->input("deskripsi"),
                    'updated_at' => Carbon::now(),
                ]
            );
        return redirect('/genre');
    }

    public function destroy($id)
    {
        DB::table('genre')->where('id', $id)->delete();

        return redirect("/genre");
    }
}
