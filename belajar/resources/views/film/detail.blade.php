@extends('layouts.master')

@section('judul')
Halaman Detail Film
@endsection
@section('content')

<img src="{{asset('uploads/'. $film->poster)}}" height="300px" width="50%">

<h3 class="text-primary my-2">{{$film->judul}}</h3>
<h5>{{$film->tahun}}</h5>
<p>{{$film->ringkasan}}</p>

<hr>
<h3>List Review</h3>
@forelse ($film->Kritik as $item)
    <div class="card">
        <div class="card-header">
            {{$item->viewer->name}}
        </div>
        <div class="card-body">
            <p class="card-text fa fa-star"> : {{$item->point}}</p>
            </div>
        <div class="card-body">
        <p class="card-text">{{$item->content}}</p>
        </div>
    </div>
@empty
    <h5>Belum ada komentar</h5>
@endforelse
    
<hr>
<form action="/kritik/{{$film->id}}" method="POST">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @csrf
    <div class="form-group">
        Rating :
        <select name="point" class="form-control">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        Komentar :
        <textarea name="content" placeholder="Tambahkan Komentar!" class="form-control" cols="30" rows="10"></textarea>
    </div>
    <button type="submit" class="btn btn-primary fa fa-paper-plane"> Kirim Komentar</button>
</form>
@endsection