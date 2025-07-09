@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="notifications-container">
    <h2>Notifikasi</h2>
        <ul class="notifications-list">
        @forelse($notifications as $notif)
            <li class="notification-item {{ $notif->is_read ? '' : 'unread' }}">
                <div class="notif-main">
                    <span>{{ $notif->message }}</span>
                    <span class="notification-date">{{ $notif->created_at->format('d M Y H:i') }}</span>
                </div>
                <form action="{{ route('notifications.read', $notif) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn secondary-btn" {{ $notif->is_read ? 'disabled' : '' }}>Tandai Dibaca</button>
                </form>
            </li>
        @empty
            <li>Tidak ada notifikasi.</li>
        @endforelse
    </ul>
</div>
@endsection