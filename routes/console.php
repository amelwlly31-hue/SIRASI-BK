<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/* | | console routes | | | this file is where you may define all of your closure based console | commands. each closure is bound to a command instance allowing a | simple approach to interacting with each command's io methods. | */

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
