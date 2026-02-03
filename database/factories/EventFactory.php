<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $endDate = (clone $startDate)->modify('+' . $this->faker->numberBetween(1, 3) . ' days');

        return [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'gold_point' => 5,
            'silver_point' => 3,
            'bronze_point' => 1,
        ];
    }
}
