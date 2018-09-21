<?php

use App\Events\RssCreatedEvent;
use App\Events\RssPublicEvent;
use Illuminate\Foundation\Inspiring;

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

Artisan::command('echo', function () {
    event(new RssCreatedEvent());
})->describe('echo demo');

Artisan::command('public_echo', function () {
    event(new RssPublicEvent());
})->describe('echo demo');
