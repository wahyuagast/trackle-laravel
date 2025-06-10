{{-- resources/views/projects/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Proyek')

@section('content')
<div class="project-form-container">
    <h1>Edit Proyek: {{ $project->name }}</h1>
    <hr>
    {{-- Form ini akan di-submit ke API endpoint untuk update --}}
    <form id="projectForm" action="{{ route('api.projects.update', $project->id) }}" method="POST">
        @include('projects._form', ['project' => $project])
    </form>
</div>
@endsection