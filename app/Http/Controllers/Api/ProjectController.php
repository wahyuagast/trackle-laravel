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
    /**
     * Menampilkan semua data proyek.
     */
    public function index()
    {
        // Ambil semua project beserta relasi PIC-nya
        $projects = Project::with('pic')->latest()->get();
        return response()->json($projects);
    }

    /**
     * Menyimpan proyek baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'deadline_date' => 'required|date|after_or_equal:start_date',
            'pic_user_id' => 'required|exists:users,id',
            'priority' => 'required|in:Tinggi,Sedang,Rendah',
            'status' => 'required|in:Belum Dimulai,Sedang Berjalan,Selesai,Ditunda,Dibatalkan',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $project = Project::create($request->all());

        return response()->json([
            'message' => 'Proyek berhasil dibuat!',
            'data' => $project
        ], 201);
    }

    /**
     * Menampilkan detail satu proyek.
     */
    public function show(Project $project)
    {
        // Load relasi yang dibutuhkan (PIC, comments, attachments)
        $project->load('pic', 'comments.user', 'attachments');
        return response()->json($project);
    }


    /**
     * Memperbarui data proyek.
     */
    public function update(Request $request, Project $project)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'deadline_date' => 'required|date|after_or_equal:start_date',
            'pic_user_id' => 'required|exists:users,id',
            'priority' => 'required|in:Tinggi,Sedang,Rendah',
            'status' => 'required|in:Belum Dimulai,Sedang Berjalan,Selesai,Ditunda,Dibatalkan',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $project->update($request->all());

        return response()->json([
            'message' => 'Proyek berhasil diperbarui!',
            'data' => $project
        ]);
    }

    /**
     * Menghapus proyek.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json([
            'message' => 'Proyek berhasil dihapus!'
        ], 200);
    }

    /**
     * Menyimpan komentar baru untuk sebuah proyek.
     */
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
            'user_id' => Auth::id(), // Mengambil ID user yang sedang login
        ]);

        // Load relasi user agar bisa menampilkan nama di frontend
        $comment->load('user');

        return response()->json([
            'message' => 'Komentar berhasil ditambahkan!',
            'data' => $comment
        ], 201);
    }
}