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
                <input type="text" class="form-control" value="Jamal">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" value="jamal123@email.com">
            </div>

            <div class="form-group">
                <label>Foto Profil</label>
                <input type="file" class="form-control">
            </div>

        </div>

        <div class="card-footer text-right">
            <button class="btn btn-success btn-sm">Simpan</button>
            <a href="{{ route('user.profil') }}" class="btn btn-secondary btn-sm">Batal</a>
        </div>
    </form>
</div>
@endsection
