<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Stamp;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    public function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $this->autoShiftChange();
        })->dailyAt('00:00');
    }

    protected function autoShiftChange()
    {
        $now = Carbon::now();
        $yesterday = Carbon::yesterday()->format('Y-m-d');

        $stamps = Stamp::whereDate('stamp_date', $yesterday)->whereNull('end_work')->get();

        foreach ($stamps as $stamp) {
            $start_work = Carbon::parse($stamp->start_work);
            $end_work = Carbon::createFromTime(23, 59, 59);
            $total_work_seconds = $start_work->diffInSeconds($end_work);
            $total_rest_seconds = $stamp->total_rest ? $this->convertTimeToSeconds($stamp->total_rest) : 0;

            $total_work_seconds -= $total_rest_seconds;
            $total_work_formatted = gmdate('H:i:s', $total_work_seconds);

            $stamp->update([
                'end_work' => $end_work->format('H:i:s'),
                'total_work' => $total_work_formatted,
            ]);
            Stamp::create([
                'user_id' => $stamp->user_id,
                'start_work' => '00:00:00',
                'stamp_date' => $now->format('Y-m-d'),
            ]);
        }
    }
    protected function convertTimeToSeconds($time)
    {
        list($hours, $minutes, $seconds) = explode(':', $time);
        return $hours * 3600 + $minutes * 60 + $seconds;
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
