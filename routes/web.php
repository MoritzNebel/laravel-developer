<?php

use App\Http\Controllers\Api\GolferController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/golfers/{longitude}/{latitude}', [GolferController::class, 'showGolferWithCoordinates'])->name('golfer_by_coordinates');