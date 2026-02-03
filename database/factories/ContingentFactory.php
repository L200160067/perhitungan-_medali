<?php

namespace Database\Factories;

use App\Models\Contingent;
use App\Models\Dojang;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contingent>
 */
class ContingentFactory extends Factory
{
    protected $model = Contingent::class;

    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'dojang_id' => Dojang::factory(),
            'name' => $this->faker->company(),
        ];
    }
}
