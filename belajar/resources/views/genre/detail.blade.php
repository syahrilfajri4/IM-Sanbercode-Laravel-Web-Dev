@extends('layouts.master')

@section('judul')
Halaman Detail Genre
@endsection

@section('content')

<h1 class="text-primary">Nama Genre : {{$genre->nama}}</h1>
<h3>Deskripsi  : {{$genre->deskripsi}}</h3>

{{-- {{dd($genre->listFilm)}} --}}
<div class="row">
@forelse ($genre->listFilm as $item)
<div class="col-4">
    <div class="card">
        <img src="{{asset('uploads/'.$item->poster)}}" width="300px" class="card-img-top" alt="...">
        <div class="card-body">
          <h2>{{$item->judul}}</h2>
          <h5>{{$item->tahun}}</h5>
          <a href="/film/{{$item->id}}" class="btn btn-primary btn-block">Read More</a>
        </div>
    </div>
</div>
@empty
    <h3>Tidak ada film di kategori ini!</h3>
@endforelse
</div>
@endsection

