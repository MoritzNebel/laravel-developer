<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Golfer;

class ApiController extends Controller
{

    public function golferByCoordinates($longitude, $latitude) {

        if (!is_numeric($longitude) || !is_numeric($latitude))  abort(400, 'Invalid coordinates');

        $earthRadius = env("EARTH_RADIUS");

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
