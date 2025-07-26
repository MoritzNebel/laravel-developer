<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Golfer;

class GolferController extends Controller
{
    public function showGolferWithCoordinates($longitude, $latitude) {

        if (!is_numeric($longitude) || !is_numeric($latitude))  abort(400, 'Invalid coordinates');

        $earthRadius = 6371;

        $golfers = Golfer::select('*')
            ->selectRaw("(
                $earthRadius * acos(
                    cos(radians(?)) *
                    cos(radians(latitude)) *
                    cos(radians(longitude) - radians(?)) +
                    sin(radians(?)) *
                    sin(radians(latitude))
                )
            ) AS distance", [$latitude, $longitude, $latitude])
            ->orderBy('distance')
            ->limit(500)
            ->get();

        return response()->json($golfers);
    }
}
