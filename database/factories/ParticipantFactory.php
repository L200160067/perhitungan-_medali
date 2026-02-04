<?php

namespace Database\Factories;

use App\Enums\ParticipantGender;
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
        $age = $this->faker->numberBetween(10, 25);
        $birthDate = $this->faker->dateTimeBetween('-' . ($age + 1) . ' years', '-' . $age . ' years');

        return [
            'dojang_id' => Dojang::factory(),
            'name' => $this->faker->name(),
            'gender' => $this->faker->randomElement(ParticipantGender::cases()),
            'birth_date' => $birthDate,
        ];
    }

    public function gender(ParticipantGender|string $gender): static
    {
        return $this->state([
            'gender' => $gender,
        ]);
    }

    public function ageBetween(int $minAge, int $maxAge): static
    {
        return $this->state(function () use ($minAge, $maxAge) {
            $age = $this->faker->numberBetween($minAge, $maxAge);
            $birthDate = $this->faker->dateTimeBetween('-' . ($age + 1) . ' years', '-' . $age . ' years');

            return [
                'birth_date' => $birthDate,
            ];
        });
    }
}
