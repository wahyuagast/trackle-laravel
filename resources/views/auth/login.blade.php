@extends('layouts.app')

@section('title', 'Login/Register - Trackle')

@section('content')
<div class="login-container">
    <div class="logo">
        <img src="{{ asset('images/trackle_logo.png') }}" alt="Logo Trackle">
    </div>
    <h2>Selamat Datang!</h2>

    @if ($errors->any())
        <div class="alert alert-danger" style="margin-bottom:15px;">
            <ul style="margin:0; padding-left:18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger" style="margin-bottom:15px;">
            {{ session('error') }}
        </div>
    @endif

    <form id="loginForm" method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="input-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
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
            <label for="regName">Nama:</label>
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

@if(session('showRegister'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('loginForm').classList.add('hidden');
        document.getElementById('registerForm').classList.remove('hidden');
    });
</script>
@endif

@endsection