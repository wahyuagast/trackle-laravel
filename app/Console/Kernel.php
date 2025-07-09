protected function schedule(Schedule $schedule)
{
    $schedule->command('reminder:projects')->daily();
}