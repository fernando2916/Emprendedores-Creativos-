<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('ordenes:cancelar-expiradas')
    ->everyMinute()
    ->withoutOverlapping();

Schedule::command('checkout:expirar-intentos')
    ->everyMinute()
    ->withoutOverlapping();