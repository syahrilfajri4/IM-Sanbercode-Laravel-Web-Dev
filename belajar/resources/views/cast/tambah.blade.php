@extends('layouts.master')

@section('judul')
Halaman Tambah Cast
@endsection

@section('content')

<form method="POST" action="/cast">

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
      <label >Nama Peran</label>
      <input type="text" name="nama" class="form-control">
    </div>
    <div class="form-group">
        <label >Umur Peran</label>
        <input type="number" name="umur" class="form-control">
      </div>
      <div class="form-group">
        <label >Bio</label>
        <textarea type="text-area" name="bio" class="form-control" cols="30" rows="10"></textarea>
      </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>

@endsection