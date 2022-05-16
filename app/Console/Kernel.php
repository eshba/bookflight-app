<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
		$schedule->call(function() {
			$query = DB::table('flight_bookings as a')->select('a.id')->where([['a.bookingprice','<',3000],['a.isconfirmed',1]])->whereRaw("(hour(now()) - hour(a.booked_at)) >= 3")->limit(1)->orderBy('a.seat')->get();
			DB::table('flight_bookings as a')->where('a.id',$query[0]->id)->update(['a.isconfirmed'=>0]);
		})->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
