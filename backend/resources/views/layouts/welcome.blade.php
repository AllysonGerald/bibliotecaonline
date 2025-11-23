<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Biblioteca Online') }} - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <x-layout.scripts />
</head>
<body style="min-height: 100vh; background: linear-gradient(135deg, #f3e8ff 0%, #fce7f3 50%, #fff1f2 100%); position: relative; overflow-x: hidden;">
    @yield('content')
</body>
</html>

