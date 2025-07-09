<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use App\Models\Notification;
use Carbon\Carbon;

class SendProjectReminders extends Command
{
    protected $signature = 'reminder:projects';
    protected $description = 'Kirim reminder ke PIC proyek sesuai jadwal';

    public function handle()
    {
        $days = [30, 15, 7, 3, 1];
        $today = Carbon::today();

        $projects = Project::with('pics')->get();

        foreach ($projects as $project) {
            foreach ($days as $d) {
                $reminderDate = Carbon::parse($project->deadline_date)->subDays($d);
                if ($reminderDate->isSameDay($today)) {
                    foreach ($project->pics as $pic) {
                        Notification::firstOrCreate([
                            'user_id' => $pic->id,
                            'project_id' => $project->id,
                            'message' => "Reminder: Proyek '{$project->name}' akan deadline dalam {$d} hari.",
                        ]);
                    }
                }
            }
        }

        $this->info('Reminder proyek dikirim.');
    }
}