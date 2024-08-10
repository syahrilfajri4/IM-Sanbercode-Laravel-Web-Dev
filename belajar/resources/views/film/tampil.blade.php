@extends('layouts.master')

@section('judul')
Halaman Tampil Film
@endsection

@section('content')

@auth
<a href="/film/create" class="btn btn-sm btn-primary my-2">Tambah Film</a>
@endauth

<hr>

<div class="row">
    @forelse ($film as $item)
    <div class="col-4">
        <div class="card">
            <img src="{{asset('uploads/'.$item->poster)}}" width="300px" class="card-img-top" alt="...">
            <div class="card-body">
              <h2>{{$item->judul}}</h2>
              <h5>{{$item->tahun}}</h5>
              <span class="badge badge-success mb-2">{{$item->genre->nama}}</span>
              <a href="/film/{{$item->id}}" class="btn btn-primary btn-block">Read More</a>
                
                @auth
                    <div class="row my-2">
                        <div class="col">
                            <a href="/film/{{$item->id}}/edit" class="btn btn-info btn-block">Edit</a>
                        </div>
                        <div class="col">
                            {{-- Delete --}}
                            <form action="/film/{{$item->id}}" method="POST">
                                @csrf
                                @method("Delete")
                            <input type="submit" value="Delete" class="btn btn-danger btn-block">
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
    @empty
        <h1>Belum ada film!</h1>
    @endforelse
    
</div>
@endsection