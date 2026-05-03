@extends('layouts.app')

@section('title','Profil User')

@section('content')
<div class="row">

    <!-- FOTO & INFO -->
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile text-center">
                <img class="profile-user-img img-fluid img-circle"
                     src="{{ asset('assets/AdminLTE/dist/img/user2-160x160.jpg') }}"
                     alt="User profile picture">

                <h3 class="profile-username mt-3">Jamal</h3>
                <p class="text-muted">Siswa</p>
            </div>
        </div>
    </div>

    <!-- DETAIL PROFIL -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Profil</h3>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Nama</th>
                        <td>Jamal</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>jamal123@email.com</td>
                    </tr>
                    <tr>
                        <th>NIS / Username</th>
                        <td>73748676</td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td>XI PPLG 2</td>
                    </tr>
                </table>
            </div>

            <div class="card-footer text-right">
    <a href="{{ route('user.profil.edit') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-edit"></i> Edit Profil
    </a>
</div>
        </div>
    </div>

</div>
@endsection
