<?php

namespace Database\Factories;

use App\Enums\PoomsaeType;
use App\Enums\TournamentGender;
use App\Enums\TournamentType;
use App\Models\Event;
use App\Models\TournamentCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TournamentCategory>
 */
class TournamentCategoryFactory extends Factory
{
    protected $model = TournamentCategory::class;

    public function definition(): array
    {
        $minAge = $this->faker->numberBetween(8, 14);
        $maxAge = $this->faker->numberBetween($minAge + 1, $minAge + 6);
        $minWeight = $this->faker->randomFloat(2, 20, 50);
        $maxWeight = $this->faker->randomFloat(2, $minWeight + 1, $minWeight + 15);

        return [
            'event_id' => Event::factory(),
            'name' => $this->faker->words(2, true),
            'type' => TournamentType::Kyourugi,
            'gender' => $this->faker->randomElement(TournamentGender::cases()),
            'age_reference_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'min_age' => $minAge,
            'max_age' => $maxAge,
            'weight_class_name' => 'Under ' . number_format($maxWeight, 2) . ' kg',
            'min_weight' => $minWeight,
            'max_weight' => $maxWeight,
            'poomsae_type' => null,
        ];
    }

    public function poomsae(): static
    {
        return $this->state(function () {
            return [
                'type' => TournamentType::Poomsae,
                'poomsae_type' => $this->faker->randomElement(PoomsaeType::cases()),
                'weight_class_name' => null,
                'min_weight' => null,
                'max_weight' => null,
            ];
        });
    }

    public function kyourugi(): static
    {
        $minWeight = $this->faker->randomFloat(2, 20, 50);
        $maxWeight = $this->faker->randomFloat(2, $minWeight + 1, $minWeight + 15);

        return $this->state([
            'type' => TournamentType::Kyourugi,
            'poomsae_type' => null,
            'weight_class_name' => 'Under ' . number_format($maxWeight, 2) . ' kg',
            'min_weight' => $minWeight,
            'max_weight' => $maxWeight,
        ]);
    }

    public function type(TournamentType|string $type): static
    {
        return $this->state([
            'type' => $type,
        ]);
    }

    public function gender(TournamentGender|string $gender): static
    {
        return $this->state([
            'gender' => $gender,
        ]);
    }

    public function poomsaeType(PoomsaeType|string $poomsaeType): static
    {
        return $this->state([
            'poomsae_type' => $poomsaeType,
        ]);
    }
}
