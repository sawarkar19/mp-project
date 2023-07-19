<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /* Update all the system settings on daily basis */
        $schedule->command('update:systemsettings')->daily();

        /* Send Share Challenge and Check whatsapp Connection */
        $schedule->command('send:offerlink')->everyTenMinutes();

        /* Send Personalised SMS (DOB and Anniversary). Also notify if dont have balance to send messages */
        $schedule->command('send:smspersonalisedwishes')->dailyAt('9:00');

        /* Send Personalised SMS */
        $schedule->command('send:smspersonalisedcustomwishes')->everyFifteenMinutes();

        /* Post to Managemedia */
        $schedule->command('post:managemedia')->dailyAt('22:00');

        /* Send daily report */
        $schedule->command('send:dailyreportstobussiness')->hourlyAt('2');

        /* Send whatsapp has been disconnected notification */
        $schedule->command('notify:whatsappdisconnected')->dailyAt('10.00');

        /* Offer Created But not posted */
        $schedule->command('notify:offernotposted')->dailyAt('12.30');

        /* Offer posted but not shared */
        $schedule->command('notify:offernotshared')->dailyAt('17.00');

        /* Perform all offer related checks to notify business */
        $schedule->command('check:offers')->dailyAt('11:00');

        /* Perform all wallet related checks to notify business */
        $schedule->command('notify:lowbalance')->hourlyAt('6');

        /* Send Share Challenge Current Offer daily*/
        $schedule->command('send:currentoffer')->dailyAt('10:00');

        /* Send Share Challenge Current Offer daily*/
        $schedule->command('update:currentoffersocialcount')->hourlyAt('2');

        /* SMS reporting */
        $schedule->command('biz:smsreport')->hourlyAt('8');

        /* Queue work */
        // $schedule->command('queue:work')->everyMinute();

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
