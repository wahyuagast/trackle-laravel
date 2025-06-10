{{-- Menggunakan layout utama yang sudah kita buat --}}
@extends('layouts.app')

{{-- Mengatur judul halaman --}}
@section('title', 'Login/Register - Trackle')

{{-- Mengisi 'content' dari layout utama dengan form login --}}
@section('content')
<div class="login-container">
    <div class="logo">
        <img src="https://via.placeholder.com/150x50?text=LOGO+INSTANSI" alt="Logo Instansi">
    </div>
    <h2>Selamat Datang!</h2>

    {{-- Nanti, action ini bisa diarahkan ke route Laravel --}}
    <form id="loginForm" method="POST" action="{{ route('login.post') }}">
        @csrf {{-- Token Keamanan Laravel --}}
        <div class="input-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="input-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn primary-btn">Login</button>
        <p class="link-text">Belum punya akun? <a href="#" id="showRegister">Daftar</a></p>
        <p class="link-text"><a href="#">Lupa Password?</a></p>
    </form>

    <form id="registerForm" class="hidden" method="POST" action="{{ route('register.post') }}">
        @csrf
        <div class="input-group">
            <label for="regEmail">Email:</label>
            <input type="email" id="regEmail" name="email" required>
        </div>
        <div class="input-group">
            <label for="regName">Nama:</label> {{-- Tambahkan input nama --}}
            <input type="text" id="regName" name="name" required>
        </div>
        <div class="input-group">
            <label for="regPassword">Password:</label>
            <input type="password" id="regPassword" name="password" required>
        </div>
        <div class="input-group">
            <label for="confirmPassword">Konfirmasi Password:</label>
            <input type="password" id="confirmPassword" name="password_confirmation" required>
        </div>
        <button type="submit" class="btn primary-btn">Daftar</button>
        <p class="link-text">Sudah punya akun? <a href="#" id="showLogin">Login</a></p>
    </form>
</div>
@endsection