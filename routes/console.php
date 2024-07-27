<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Artisan::call(new \App\Console\Commands\GetExchangeRates())->timezone('Europe/London')->dailyAt('00:00');

