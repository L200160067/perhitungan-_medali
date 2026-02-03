<?php

namespace Database\Factories;

use App\Models\Contingent;
use App\Models\Medal;
use App\Models\Registration;
use App\Models\TournamentCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Registration>
 */
class RegistrationFactory extends Factory
{
    protected $model = Registration::class;

    public function definition(): array
    {
        return [
            'category_id' => TournamentCategory::factory(),
            'contingent_id' => Contingent::factory(),
            'medal_id' => null,
            'status' => 'registered',
        ];
    }

    public function awarded(): static
    {
        return $this->state([
            'medal_id' => Medal::factory(),
        ]);
    }

    public function status(string $status): static
    {
        return $this->state([
            'status' => $status,
        ]);
    }
}
