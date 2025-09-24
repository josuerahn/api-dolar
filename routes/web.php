<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/scheduler/ping', function() {
    abort_unless(request('token') === env('SCHEDULER_TOKEN'), 403);
    Artisan::call('schedule:run');
    return response()->json(['ok'=>true, 'ran'=>now()->toDateTimeString()]);
});
