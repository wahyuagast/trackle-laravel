<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectViewController extends Controller
{
    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('projects.create', compact('users'));
    }

    public function show(Project $project)
    {
        $project->load('pic', 'comments.user'); // Eager load relasi
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $users = User::orderBy('name')->get();
        return view('projects.edit', compact('project', 'users'));
    }
}