@extends('layouts.app')

@section('title', 'Dashboard - Trackle')

@section('header')
<header class="main-header">
    <div class="header-left">
        <h1>Trackle Dashboard</h1>
    </div>
    <div class="header-right">
        <span class="user-name">Halo, {{ Auth::user()->name ?? 'Pengguna' }}</span>
        @php
            $notifCount = \App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->count();
        @endphp
        <a href="{{ route('notifications.index') }}" class="notification-icon" id="showNotifications">
            <i class="fas fa-bell"></i>
            @if($notifCount > 0)
                <span class="badge">{{ $notifCount }}</span>
            @endif
        </a>
        <a href="{{ route('projects.create') }}" class="btn add-project-btn">Tambah Proyek</a>
        <a href="#" class="btn delete-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>
    </div>
</header>
@endsection

@section('content')
@php
    $bgColors = ['#e3f2fd', '#ffe0b2', '#c8e6c9', '#f8bbd0', '#d1c4e9', '#b2dfdb', '#fff9c4', '#d7ccc8', '#f0f4c3', '#ffe082'];
    $fontColors = ['#1565c0', '#e65100', '#2e7d32', '#ad1457', '#4527a0', '#00695c', '#b28900', '#4e342e', '#616161', '#ff6f00'];
    function pillColor($seed, $bgColors, $fontColors) {
        $idx = crc32($seed) % count($bgColors);
        return [
            'bg' => $bgColors[$idx],
            'font' => $fontColors[$idx]
        ];
    }
@endphp

<div class="dashboard-content">
    <section class="project-summary">
        <h2>RINGKASAN PROYEK</h2>
        <hr>
        <div class="summary-cards">
            <div class="summary-card">
                <h3>Proyek Mendatang</h3>
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
                @forelse($upcoming_projects as $project)
                <tr>
                    <td>{{ $project->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($project->deadline_date)->format('d F Y') }}</td>
                    <td><span class="priority {{ strtolower($project->priority) }}">{{ $project->priority }}</span></td>
                    <td>
                        @forelse($project->pics as $pic)
                            @php $color = pillColor($pic->id, $bgColors, $fontColors); @endphp
                            <span class="pic-pill" style="background-color: {{ $color['bg'] }}; color: {{ $color['font'] }};">
                                {{ $pic->name }}
                            </span>
                        @empty
                            <span>Tidak ada PIC</span>
                        @endforelse
                    </td>
                    <td>
                        <a href="{{ route('projects.show', $project->id) }}" class="action-btn" title="Detail">
                            <i class="fas fa-eye"></i> <span class="d-none d-md-inline">Detail</span>
                        </a>
                    </td>
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
                    <td><span class="status-progress">{{ $project->progress }}% Selesai</span></td>
                    <td>
                        @forelse($project->pics as $pic)
                            @php $color = pillColor($pic->id, $bgColors, $fontColors); @endphp
                            <span class="pic-pill" style="background-color: {{ $color['bg'] }}; color: {{ $color['font'] }};">
                                {{ $pic->name }}
                            </span>
                        @empty
                            <span>Tidak ada PIC</span>
                        @endforelse
                    </td>
                    <td>
                        <a href="{{ route('projects.show', $project->id) }}" class="action-btn" title="Detail">
                            <i class="fas fa-eye"></i> <span class="d-none d-md-inline">Detail</span>
                        </a>
                    </td>
                </tr>
                 @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada proyek yang sedang berjalan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </section>

    <section class="project-list">
        <h2>PROYEK TELAH SELESAI</h2>
        <hr>
        <table>
            <thead>
                <tr>
                    <th>Nama Proyek</th>
                    <th>Deadline</th>
                    <th>PIC</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($completed_projects as $project)
                <tr>
                    <td>{{ $project->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($project->deadline_date)->format('d F Y') }}</td>
                    <td>
                        @forelse($project->pics as $pic)
                            @php $color = pillColor($pic->id, $bgColors, $fontColors); @endphp
                            <span class="pic-pill" style="background-color: {{ $color['bg'] }}; color: {{ $color['font'] }};">
                                {{ $pic->name }}
                            </span>
                        @empty
                            <span>Tidak ada PIC</span>
                        @endforelse
                    </td>
                    <td>
                        <a href="{{ route('projects.show', $project->id) }}" class="action-btn" title="Detail">
                            <i class="fas fa-eye"></i> <span class="d-none d-md-inline">Detail</span>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak ada proyek yang telah selesai.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </section>
</div>
@endsection

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>