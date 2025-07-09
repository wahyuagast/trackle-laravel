@extends('layouts.app')

@section('title', 'Edit Proyek')

@section('content')
<div class="project-form-container">
    <h1>Edit Proyek: {{ $project->name }}</h1>
    <hr>
    <form id="projectForm" action="{{ route('api.projects.update', $project->id) }}" method="POST">
        @include('projects._form', ['project' => $project])
    </form>
</div>
@endsection