<?php

namespace Database\Factories;

use App\Models\Dojang;
use App\Models\Participant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Participant>
 */
class ParticipantFactory extends Factory
{
    protected $model = Participant::class;

    public function definition(): array
    {
        return [
            'dojang_id' => Dojang::factory(),
            'name' => $this->faker->name(),
            'gender' => $this->faker->randomElement(Participant::GENDERS),
            'birth_date' => $this->faker->dateTimeBetween('-30 years', '-10 years'),
        ];
    }
}
