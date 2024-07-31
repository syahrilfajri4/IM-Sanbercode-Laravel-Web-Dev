@extends('layouts.master')

@section('judul')
Halaman Home
@endsection

@section('content')
<h2>Social Media Developer Santai Berkualitas</h2>
<h4>Belajar dan Berbagi agar hidup ini semakin santai berkualitas</h4>
<h2>Benefit Join di SanberBook</h2>
<ul>
    <li>Mendapatkan motivasi dari sesama developer</li>
    <li>Sharing knowledge dari para mastah Sanber</li>
    <li>Dibuat oleh calon web developer terbaik</li>
</ul>

<h2>Cara Bergabung ke SanberBook</h2>
<ol>
    <li>Mengunjungi Website ini</li>
    <li>Mendaftar di <a href="{{ route('register') }}">Form Sign Up</a></li>
    <li>Selesai</li>
</ol>
@endsection
    