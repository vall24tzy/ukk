<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'Penggajian')</title>
    <link rel="stylesheet" href="{{ asset('css/penggajian.css') }}">
    @stack('styles')
</head>
<body class="@yield('body_class')">
    @yield('content')
    @stack('scripts')
</body>
</html>
