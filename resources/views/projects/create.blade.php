{{-- resources/views/projects/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Proyek Baru')

@section('header')
    {{-- Header bisa dibuat parsial juga jika diinginkan --}}
@endsection

@section('content')
<div class="project-form-container">
    <h1>Tambah Proyek Baru</h1>
    <hr>
    {{-- Kita gunakan JavaScript untuk submit form ini ke API --}}
    <form id="projectForm" action="{{ route('api.projects.store') }}" method="POST">
        @include('projects._form')
    </form>
</div>
@endsection