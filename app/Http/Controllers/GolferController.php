<?php

namespace App\Http\Controllers;

use App\Models\Golfer;
use Illuminate\Http\Request;

class GolferController extends Controller
{

    public function golferByCoordinatesAsCsv($longitude, $latitude)
    {
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

        $csvHeader = ['id', 'name', 'debitor_account', 'latitude', 'longitude', 'distance']; 

        $callback = function() use ($golfers, $csvHeader) {
            $file = fopen('php://output', 'w');

            fputcsv($file, $csvHeader, ';');

            foreach ($golfers as $golfer) {
                fputcsv($file, [
                    $golfer->id,
                    $golfer->name,
                    $golfer->debitor_account,
                    $golfer->latitude,
                    $golfer->longitude,
                    round($golfer->distance, 2),
                ],';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"golfers.csv\"",
        ]);
    }
}
