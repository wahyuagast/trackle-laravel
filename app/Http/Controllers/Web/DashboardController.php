<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data dari database dan proses
        $upcoming_projects = Project::with('pic')
            ->where('deadline_date', '>=', Carbon::now())
            ->where('deadline_date', '<=', Carbon::now()->addDays(30))
            ->where('status', '!=', 'Selesai')
            ->get();

        $ongoing_projects = Project::with('pic')
            ->where('status', 'Sedang Berjalan')
            ->get();

        // Kirim data ke view
        return view('dashboard', [
            'upcoming_projects' => $upcoming_projects,
            'ongoing_projects' => $ongoing_projects,
            'upcoming_count' => Project::where('status', 'Belum Dimulai')->count(),
            'ongoing_count' => $ongoing_projects->count(),
            'completed_count' => Project::where('status', 'Selesai')->count(),
        ]);
    }
}