<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('pics')->latest()->get();
        return response()->json($projects);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'deadline_date' => 'required|date|after_or_equal:start_date',
            'pic_user_id' => 'required|array',
            'pic_user_id.*' => 'exists:users,id',
            'priority' => 'required|in:Tinggi,Sedang,Rendah',
            'status' => 'required|in:Belum Dimulai,Sedang Berjalan,Selesai,Ditunda,Dibatalkan',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->except('pic_user_id');
        $project = Project::create($data);
        $project->pics()->sync($request->pic_user_id);

        return response()->json([
            'message' => 'Proyek berhasil dibuat!',
            'data' => $project->load('pics')
        ], 201);
    }

    public function show(Project $project)
    {
        $project->load('pics', 'comments.user', 'attachments');
        return response()->json($project);
    }

    public function update(Request $request, Project $project)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'deadline_date' => 'required|date|after_or_equal:start_date',
            'pic_user_id' => 'required|array',
            'pic_user_id.*' => 'exists:users,id',
            'priority' => 'required|in:Tinggi,Sedang,Rendah',
            'status' => 'required|in:Belum Dimulai,Sedang Berjalan,Selesai,Ditunda,Dibatalkan',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->except('pic_user_id');
        $project->update($data);
        $project->pics()->sync($request->pic_user_id);

        return response()->json([
            'message' => 'Proyek berhasil diperbarui!',
            'data' => $project->load('pics')
        ]);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json([
            'message' => 'Proyek berhasil dihapus!'
        ], 200);
    }

    public function storeComment(Request $request, Project $project)
    {
        $validator = Validator::make($request->all(), [
            'body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $comment = $project->comments()->create([
            'body' => $request->body,
            'user_id' => Auth::id(),
        ]);

        $comment->load('user');

        return response()->json([
            'message' => 'Komentar berhasil ditambahkan!',
            'data' => $comment
        ], 201);
    }
}