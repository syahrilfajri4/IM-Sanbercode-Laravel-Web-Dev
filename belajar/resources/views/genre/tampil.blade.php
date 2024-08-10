@extends('layouts.master')

@section('judul')
Halaman Tampil Genre
@endsection

@section('content')

<a href="/genre/create" class="btn btn-sm btn-danger mb-3">Tambah Genre Film</a>

<table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nama Genre</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
        @forelse ($genre as $key => $item)
        <tr>
            <th scope="row">{{$key+1}}</th>
            <td>{{$item->nama}}</td>
            <td>
                <form action="/genre/{{$item->id}}" method="POST">
                  <a href="/genre/{{$item->id}}" class="btn btn-warning btn-sm">Detail</a>
                  <a href="/genre/{{$item->id}}/edit" class="btn btn-primary btn-sm">Edit</a>
                  @csrf
                  @method("delete")
                  <input type="submit" class="btn btn-danger btn-sm" value="Delete">
                </form>
            </td>
          </tr>
        @empty
            <p>No genre!</p>
        @endforelse
      
    </tbody>
  </table>
@endsection