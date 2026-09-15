<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="{{ asset('css/penggajian.css') }}">
</head>
<body class="login-page">
<div class="login-card forgot-card">
    <h1>LUPA PASSWORD</h1>
    <p>ubah password akun admin</p>

    @if ($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="post" action="{{ route('password.reset') }}">
        @csrf
        <label>email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>

        <label>password baru</label>
        <input type="password" name="password" required minlength="6">

        <label>konfirmasi password</label>
        <input type="password" name="password_confirmation" required minlength="6">

        <a class="forgot back-login" href="{{ route('login') }}">&larr; kembali ke login</a>
        <button type="submit">UBAH PASSWORD</button>
    </form>
</div>
</body>
</html>
