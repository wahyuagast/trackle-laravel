@extends('layouts.app')

@section('title', 'Dashboard - Trackle')

{{-- Header yang spesifik untuk halaman ini --}}
@section('header')
<header class="main-header">
    <div class="header-left">
        <img src="https://via.placeholder.com/100x30?text=LOGO" alt="Logo Instansi" class="header-logo">
        <h1>Dashboard Aplikasi Proyek</h1>
    </div>
    <div class="header-right">
        <span class="user-name">Halo, {{ Auth::user()->name ?? 'Pengguna' }}</span>
        <a href="#" class="notification-icon" id="showNotifications">
            <i class="fas fa-bell"></i>
            <span class="badge">3</span>
        </a>
        <a href="{{ route('projects.create') }}" class="btn add-project-btn">Tambah Proyek +</a>

        {{-- ================================================================ --}}
        {{-- TOMBOL LOGOUT --}}
        {{-- ================================================================ --}}
        <a href="#" class="btn delete-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>
        {{-- ================================================================ --}}

    </div>
</header>
@endsection

@section('content')
<div class="dashboard-content">
    <section class="project-summary">
        <h2>RINGKASAN PROYEK</h2>
        <hr>
        <div class="summary-cards">
            <div class="summary-card">
                <h3>Proyek Mendatang</h3>
                {{-- Data ini akan kita isi dari controller --}}
                <p class="count">{{ $upcoming_count }}</p>
            </div>
            <div class="summary-card">
                <h3>Proyek Berjalan</h3>
                <p class="count">{{ $ongoing_count }}</p>
            </div>
            <div class="summary-card">
                <h3>Proyek Selesai</h3>
                <p class="count">{{ $completed_count }}</p>
            </div>
        </div>
    </section>

    <section class="project-list">
        <h2>PROYEK MENDATANG (30 Hari ke Depan)</h2>
        <hr>
        <table>
            <thead>
                <tr>
                    <th>Nama Proyek</th>
                    <th>Deadline</th>
                    <th>Prioritas</th>
                    <th>PIC</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop melalui data proyek dari controller --}}
                @forelse($upcoming_projects as $project)
                <tr>
                    <td>{{ $project->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($project->deadline_date)->format('d F Y') }}</td>
                    <td><span class="priority {{ strtolower($project->priority) }}">{{ $project->priority }}</span></td>
                    <td>{{ $project->pic->name ?? 'Tidak ada PIC' }}</td> {{-- Mengambil nama dari relasi 'pic' --}}
                    <td><a href="{{ route('projects.show', $project->id) }}">Detail</a></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada proyek mendatang.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </section>

    <section class="project-list">
        <h2>PROYEK SEDANG BERJALAN</h2>
        <hr>
        <table>
            <thead>
                <tr>
                    <th>Nama Proyek</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>PIC</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ongoing_projects as $project)
                <tr>
                    <td>{{ $project->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($project->deadline_date)->format('d F Y') }}</td>
                    <td><span class="status-progress">{{-- Di sini bisa ditambahkan progress bar --}}70% Selesai</span></td>
                    <td>{{ $project->pic->name ?? 'Tidak ada PIC' }}</td>
                    <td><a href="{{ route('projects.show', $project->id) }}">Detail</a></td>
                </tr>
                 @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada proyek yang sedang berjalan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </section>
</div>
@endsection

{{-- ================================================================ --}}
{{-- FORM LOGOUT TERSEMBUNYI --}}
{{-- ================================================================ --}}
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
{{-- ================================================================ --}}