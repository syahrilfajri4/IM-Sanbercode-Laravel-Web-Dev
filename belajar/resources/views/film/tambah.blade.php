@extends('layouts.master')

@section('judul')
Halaman Tambah Film
@endsection

@section('content')

<form method="POST" action="/film" enctype="multipart/form-data">

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
      <label >Judul Film</label>
      <input type="text" name="judul" class="form-control">
    </div>
    <div class="form-group">
        <label >Ringkasan Film</label>
        <textarea type="text-area" name="ringkasan" class="form-control" cols="30" rows="10"></textarea>
    </div>
    <div class="form-group">
        <label >Tahun Film</label>
        <input type="number" name="tahun" class="form-control">
      </div>
      <div class="form-group">
        <label >Genre</label>
        <select name="genre_id" class="form-control">
            <option value="">--Pilih Genre--</option>
            @forelse ($genre as $item)
                <option value="{{$item->id}}">{{$item->nama}}</option>
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