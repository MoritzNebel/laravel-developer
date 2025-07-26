<?php

namespace Database\Factories;

use App\Models\Golfer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Random\RandomException;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Golfer>
 */
class GolferFactory extends Factory
{
    private static int $debitorAccount = 1;

    /**
     * Define the model's default state.
     *
     * @return array{debitor_account: integer, name: string, email: string, born_at: \Carbon\CarbonImmutable, latitude: float, longitude: float}
     * @throws RandomException
     */
    public function definition(): array
    {
        return [
            'debitor_account' => self::$debitorAccount++,
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'born_at' => today()->subDays(random_int(0, 365))->subYears(random_int(10, 100))->toImmutable(),
            // approximately the outer boundaries of Germany
            'latitude' => round(fake()->longitude(47.3, 55.0), 4),
            'longitude' => round(fake()->latitude(5.8, 15.0), 4),
        ];
    }
}
