<?php

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

Artisan::command('your:command', function (Command $command) {
    $command->info('Message');
})->describe('Description');
