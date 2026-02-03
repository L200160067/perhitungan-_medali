<?php

namespace Database\Factories;

use App\Models\Medal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Medal>
 */
class MedalFactory extends Factory
{
    protected $model = Medal::class;

    public function definition(): array
    {
        $map = [
            'gold' => 1,
            'silver' => 2,
            'bronze' => 3,
        ];

        $name = $this->faker->randomElement(array_keys($map));

        return [
            'name' => $name,
            'rank' => $map[$name],
        ];
    }

    public function gold(): static
    {
        return $this->state([
            'name' => 'gold',
            'rank' => 1,
        ]);
    }

    public function silver(): static
    {
        return $this->state([
            'name' => 'silver',
            'rank' => 2,
        ]);
    }

    public function bronze(): static
    {
        return $this->state([
            'name' => 'bronze',
            'rank' => 3,
        ]);
    }
}
