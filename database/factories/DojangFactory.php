<?php

namespace Database\Factories;

use App\Models\Dojang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dojang>
 */
class DojangFactory extends Factory
{
    protected $model = Dojang::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
        ];
    }
}
