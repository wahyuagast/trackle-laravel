@extends('layouts.app')

@section('title', 'Tambah Proyek Baru')

@section('header')
@endsection

@section('content')
<div class="project-form-container">
    <h1>Tambah Proyek Baru</h1>
    <hr>
    <form id="projectForm" action="{{ route('api.projects.store') }}" method="POST">
        @include('projects._form')
    </form>
</div>
@endsection