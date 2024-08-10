@extends('layouts.master')

@section('judul')
Halaman Edit Film
@endsection

@section('content')

<form method="POST" action="/film/{{$film->id}}" enctype="multipart/form-data">

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
    @method("PUT")
    <div class="form-group">
      <label >Judul Film</label>
      <input type="text" value="{{$film->judul}}" name="judul" class="form-control">
    </div>
    <div class="form-group">
        <label >Ringkasan Film</label>
        <textarea type="text-area" name="ringkasan" class="form-control" cols="30" rows="10">{{$film->ringkasan}}</textarea>
    </div>
    <div class="form-group">
        <label >Tahun Film</label>
        <input type="number" value="{{$film->tahun}}" name="tahun" class="form-control">
      </div>
      <div class="form-group">
        <label >Genre</label>
        <select name="genre_id" class="form-control">
            <option value="">--Pilih Genre--</option>
            @forelse ($genre as $item)
                @if ($item->id == $film->genre_id)
                <option value="{{$item->id}}" selected>{{$item->nama}}</option>     
                @else
                <option value="{{$item->id}}">{{$item->nama}}</option>
                @endif
            @empty
                <option value="">Tidak ada genre! Silahkan ditambahkan</option>
            @endforelse
        </select>    
    </div>
    <div class="form-group">
        <label >Poster Film</label>
        <input type="file" name="poster" class="form-control-file">
      </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>

@endsection