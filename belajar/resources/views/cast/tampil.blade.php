@extends('layouts.master')

@section('judul')
Halaman Tampil Data
@endsection

@section('content')

<a href="/cast/create" class="btn btn-sm btn-danger mb-3">Tambah Cast</a>

<table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nama</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
        @forelse ($cast as $key => $item)
        <tr>
            <th scope="row">{{$key+1}}</th>
            <td>{{$item->nama}}</td>
            <td>
                <form action="/cast/{{$item->id}}" method="POST">
                  <a href="/cast/{{$item->id}}" class="btn btn-warning btn-sm">Detail</a>
                  <a href="/cast/{{$item->id}}/edit" class="btn btn-primary btn-sm">Edit</a>
                  @csrf
                  @method("delete")
                  <input type="submit" class="btn btn-danger btn-sm" value="Delete">
                </form>
            </td>
          </tr>
        @empty
            <p>No users</p>
        @endforelse
      
    </tbody>
  </table>
@endsection