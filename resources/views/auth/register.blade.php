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

        <!-- Nama -->
        <input type="text" name="name"
               class="form-control mb-2 @error('name') is-invalid @enderror"
               placeholder="Nama"
               value="{{ old('name') }}" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror

        <!-- NISN (DIUBAH JADI ANGKA) -->
        <input type="number" name="nisn"
               class="form-control mb-2 @error('nisn') is-invalid @enderror"
               placeholder="NISN (10 digit)"
               value="{{ old('nisn') }}"
               min="0"
               oninput="this.value = this.value.slice(0,10)"
               required>
        @error('nisn') <div class="invalid-feedback">{{ $message }}</div> @enderror

        <!-- Kelas -->
        <select name="kelas"
                class="form-select mb-2 @error('kelas') is-invalid @enderror" required>
            <option value="">Pilih Kelas</option>
            <option value="10" {{ old('kelas')=='10'?'selected':'' }}>Kelas 10</option>
            <option value="11" {{ old('kelas')=='11'?'selected':'' }}>Kelas 11</option>
            <option value="12" {{ old('kelas')=='12'?'selected':'' }}>Kelas 12</option>
        </select>
        @error('kelas') <div class="invalid-feedback">{{ $message }}</div> @enderror

        <!-- Jurusan -->
        <select name="jurusan"
                class="form-select mb-2 @error('jurusan') is-invalid @enderror" required>
            <option value="">Pilih Jurusan</option>
            <option value="IPA" {{ old('jurusan')=='IPA'?'selected':'' }}>IPA</option>
            <option value="IPS" {{ old('jurusan')=='IPS'?'selected':'' }}>IPS</option>
            <option value="RPL" {{ old('jurusan')=='RPL'?'selected':'' }}>RPL</option>
            <option value="TKJ" {{ old('jurusan')=='TKJ'?'selected':'' }}>TKJ</option>
        </select>
        @error('jurusan') <div class="invalid-feedback">{{ $message }}</div> @enderror

        <!-- Email -->
        <input type="email" name="email"
               class="form-control mb-2 @error('email') is-invalid @enderror"
               placeholder="Email"
               value="{{ old('email') }}" required>
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror

        <!-- Password -->
        <input type="password" name="password"
               class="form-control mb-2 @error('password') is-invalid @enderror"
               placeholder="Password" required>
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror

        <!-- Konfirmasi Password -->
        <input type="password" name="password_confirmation"
               class="form-control mb-3"
               placeholder="Konfirmasi Password" required>

        <button class="btn btn-primary w-100">Daftar</button>
    </form>

    <p class="text-center mt-3">
        Sudah punya akun? <a href="{{ route('login') }}">Login</a>
    </p>
</div>

</body>
</html>