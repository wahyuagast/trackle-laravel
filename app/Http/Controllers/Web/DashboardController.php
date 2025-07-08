<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $upcoming_projects = Project::with('pics')
            ->where('deadline_date', '>=', Carbon::now())
            ->where('deadline_date', '<=', Carbon::now()->addDays(30))
            ->where('status', '!=', 'Selesai')
            ->get();

        $ongoing_projects = Project::with('pics')
            ->where('status', 'Sedang Berjalan')
            ->get();

        $completed_projects = Project::with('pics')->where('status', 'Selesai')->get();

        return view('dashboard', [
            'upcoming_projects' => $upcoming_projects,
            'ongoing_projects' => $ongoing_projects,
            'upcoming_count' => Project::where('status', 'Belum Dimulai')->count(),
            'ongoing_count' => $ongoing_projects->count(),
            'completed_count' => Project::where('status', 'Selesai')->count(),
            'completed_projects' => $completed_projects,
        ]);
    }
}