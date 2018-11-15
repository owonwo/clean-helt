<?php

use Illuminate\Foundation\Inspiring;
use App\Models\Patient;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('user', function () {
    $this->comment(Patient::all()->random()->email);
})->describe('Display an inspiring quote');
