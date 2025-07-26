<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\GolferController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/{longitude}/{latitude}', [ApiController::class, 'golferByCoordinates'])->name('golfer_by_coordinates_api');
Route::get('/golfers/{longitude}/{latitude}', [GolferController::class, 'golferByCoordinatesAsCsv'])->name('golfer_by_coordinates_as_csv');