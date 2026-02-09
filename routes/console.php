<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('debug:event-import {file}', function ($file) {
    (new \App\Console\Commands\DebugEventImport)->handle();
});
