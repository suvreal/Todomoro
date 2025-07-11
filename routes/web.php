<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

Route::resource('tasks', TaskController::class);

Route::fallback(function () {
    return redirect()->route('tasks.index');
});
