@extends('layouts.master')

@section('judul')
Halaman Detail Data
@endsection

@section('content')

<h1 class="text-primary">Biodata Cast : {{$cast->nama}}</h1>
<h3>Umur : {{$cast->umur}}</h3>
<h3>Bio  : {{$cast->bio}}</h3>
@endsection