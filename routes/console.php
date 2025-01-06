<?php

// use Illuminate\Foundation\Inspiring;
// use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();


// Schedule::command('backup:run')->dailyAt('22:00')->timezone('Asia/Kolkata')->withoutOverlapping(10);
// Schedule::command('backup:clean')->weeklyOn(1, '6:00')->timezone('Asia/Kolkata')->withoutOverlapping(10);

Schedule::command('backup:run')->everyMinute()->withoutOverlapping(10);
Schedule::command('backup:clean')->everyTwoMinutes()->withoutOverlapping(10);
