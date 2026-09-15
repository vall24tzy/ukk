<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Masuk</title>
    <link rel="stylesheet" href="{{ asset('css/penggajian.css') }}">
</head>
<body class="login-page">
<div class="login-card">
    <h1>MASUK</h1>
    <p>masukan user &amp; password</p>

    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="post" action="{{ route('login.process') }}">
        @csrf
        <label>username</label>
        <input type="email" name="email" value="{{ old('email') }}" required>

        <label>password</label>
        <input type="password" name="password" required>

        <a class="forgot" href="{{ route('password.forgot') }}">lupa password?</a>
        <button type="submit">SUBMIT</button>
    </form>
</div>
</body>
</html>
