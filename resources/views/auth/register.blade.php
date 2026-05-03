<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

<div class="card p-4 shadow" style="width: 400px;">
    <h4 class="text-center mb-3">Register</h4>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('register.process') }}">
        @csrf

        <input type="text" name="name" class="form-control mb-2" placeholder="Nama" required>
        <input type="text" name="nisn" class="form-control mb-2" placeholder="NISN" required>
        
        <select name="kelas" class="form-control mb-2" required>
            <option value="">Pilih Kelas</option>
            <option value="10">Kelas 10</option>
            <option value="11">Kelas 11</option>
            <option value="12">Kelas 12</option>
        </select>

        <select name="jurusan" class="form-control mb-2" required>
            <option value="">Pilih Jurusan</option>
            <option value="IPA">IPA</option>
            <option value="IPS">IPS</option>
            <option value="RPL">RPL</option>
            <option value="TKJ">TKJ</option>
        </select>

        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
        <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
        <input type="password" name="password_confirmation" class="form-control mb-3" placeholder="Konfirmasi Password" required>

        <button class="btn btn-primary w-100">Daftar</button>
    </form>

    <p class="text-center mt-3">
        Sudah punya akun? <a href="{{ route('login') }}">Login</a>
    </p>
</div>

</body>
</html>