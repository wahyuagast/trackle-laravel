@extends('layouts.app')

@section('title', 'Detail Proyek: ' . $project->name)

@section('header')
<header class="main-header">
    <div class="header-left">
        <a href="{{ route('dashboard') }}" class="back-link"><i class="fas fa-arrow-left"></i> Kembali</a>
        <h1>Detail Proyek</h1>
    </div>
    <div class="header-right">
        <span class="user-name">Halo, {{ Auth::user()->name }}</span>
        <a href="{{ route('projects.edit', $project->id) }}" class="btn add-project-btn">Edit Proyek</a>
    </div>
</header>
@endsection

@section('content')
<div class="project-form-container">
    <section class="project-details">
        <h2>{{ $project->name }}</h2>
        <p style="color: #555; margin-top: -10px; margin-bottom: 20px;">{{ $project->description }}</p>

        <table class="project-list" style="border: none;">
            <tbody>
                <tr>
                    <td style="width: 20%; font-weight: bold; border: 1px solid #ddd;">Tanggal Mulai</td>
                    <td style="border: 1px solid #ddd;">{{ \Carbon\Carbon::parse($project->start_date)->isoFormat('D MMMM YYYY') }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; border: 1px solid #ddd;">Deadline</td>
                    <td style="border: 1px solid #ddd;">{{ \Carbon\Carbon::parse($project->deadline_date)->isoFormat('D MMMM YYYY') }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; border: 1px solid #ddd;">Person In Charge (PIC)</td>
                    <td style="border: 1px solid #ddd;">{{ $project->pics->pluck('name')->join(', ') }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; border: 1px solid #ddd;">Prioritas</td>
                    <td style="border: 1px solid #ddd;"><span class="priority {{ strtolower($project->priority) }}">{{ $project->priority }}</span></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; border: 1px solid #ddd;">Status</td>
                    <td style="border: 1px solid #ddd;"><span class="status-progress">{{ $project->status }}</span></td>
                </tr>
            </tbody>
        </table>
    </section>

    <section id="commentSection" class="comment-section" style="margin-top: 40px;">
        <h2>KOMENTAR</h2>
        <hr>
        <div class="comments-list">
            @forelse($project->comments as $comment)
            <div class="comment-item">
                <span class="comment-author">{{ optional($comment->user)->name }}</span> 
                <span class="comment-date">({{ $comment->created_at->diffForHumans() }}):</span>
                <p>{{ $comment->body }}</p>
            </div>
            @empty
            <p>Belum ada komentar.</p>
            @endforelse
        </div>
        <div class="new-comment">
            <form id="newCommentForm" action="{{ route('api.projects.comments.store', $project->id) }}" method="POST" style="display: flex; gap: 10px; align-items: flex-end;">
                @csrf
                <textarea id="newCommentText" name="body" placeholder="Tambah Komentar..." rows="2" required style="flex:1; resize: vertical; min-height: 38px;"></textarea>
                <button type="submit" class="btn primary-btn" id="sendCommentButton" style="margin:0;">Kirim</button>
            </form>
        </div>
    </section>
</div>
@endsection