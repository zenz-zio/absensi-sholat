@extends('layouts.app')

@section('title','Edit Profil')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Profil</h3>
    </div>

    <form action="{{ route('user.profil.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card-body">

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="name" class="form-control"
                   value="{{ auth()->user()->name }}">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                   value="{{ auth()->user()->email }}">
        </div>

        <div class="form-group">
            <label>Foto Profil</label>
            <input type="file" name="foto" class="form-control">
        </div>

    </div>

    <div class="card-footer text-right">
        <button type="submit" class="btn btn-success btn-sm">Simpan</button>
        <a href="{{ route('user.profil') }}" class="btn btn-secondary btn-sm">Batal</a>
    </div>
</form>
@endsection
