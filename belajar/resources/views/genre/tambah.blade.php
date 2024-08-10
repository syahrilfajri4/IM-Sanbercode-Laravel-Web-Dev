@extends('layouts.master')

@section('judul')
Halaman Tambah Genre
@endsection

@section('content')

<form method="POST" action="/genre">

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
      <label >Nama Genre</label>
      <input type="text" name="nama" class="form-control">
    </div>
      <div class="form-group">
        <label >Deskripsi</label>
        <textarea type="text-area" name="deskripsi" class="form-control" cols="30" rows="10"></textarea>
      </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>

@endsection