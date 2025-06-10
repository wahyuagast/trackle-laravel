<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Meta untuk CSRF Token, penting untuk AJAX/Fetch nanti --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Trackle - Aplikasi Proyek')</title>

    {{-- Memuat CSS menggunakan helper asset() untuk URL yang benar --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    {{-- Header akan ditampilkan jika halaman bukan login/register --}}
    @hasSection('header')
        @yield('header')
    @endif

    <div class="container">
        {{-- Konten spesifik dari setiap halaman akan dimuat di sini --}}
        @yield('content')
    </div>

    {{-- Memuat JS menggunakan helper asset() --}}
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>