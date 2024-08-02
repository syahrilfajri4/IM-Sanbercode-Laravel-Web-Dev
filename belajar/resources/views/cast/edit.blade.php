@extends('layouts.master')

@section('judul')
Halaman Edit Cast
@endsection

@section('content')

<form method="POST" action="/cast/{{$cast->id}}">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @method('PUT')
    @csrf
    <div class="form-group">
      <label >Nama Peran</label>
      <input type="text" value="{{$cast->nama}}" name="nama" class="form-control">
    </div>
    <div class="form-group">
        <label >Umur Peran</label>
        <input type="number" value="{{$cast->umur}}" name="umur" class="form-control">
      </div>
      <div class="form-group">
        <label >Bio</label>
        <textarea type="text-area" name="bio" class="form-control" cols="30" rows="10">{{$cast->bio}}</textarea>
      </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>

@endsection