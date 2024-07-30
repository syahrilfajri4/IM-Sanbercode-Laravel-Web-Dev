<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BiodataController extends Controller
{
    public function showRegisterForm()
    {
        return view('register');
    }

    public function processRegister(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => 'required|string',
            'nationality' => 'required|string',
            'language_spoken' => 'required|array',
            'bio' => 'required|string',
        ]);

        return redirect()->route('welcome', [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'gender' => $data['gender'],
            'nationality' => $data['nationality'],
            'language_spoken' => implode(', ', $data['language_spoken']),
            'bio' => $data['bio'],
        ]);
    }

    public function welcome(Request $request)
    {
        return view('welcome', [
            'first_name' => $request->query('first_name'),
            'last_name' => $request->query('last_name'),
            // 'gender' => $request->query('gender'),
            // 'nationality' => $request->query('nationality'),
            // 'language_spoken' => $request->query('language_spoken'),
            // 'bio' => $request->query('bio'),
        ]);
    }
}
