<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobOpening>
 */
class JobOpeningFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate a random start date within the next year
        $dateNeeded = Carbon::now()->addDays(rand(0, 365));

        // Generate an expiry date that is after the start date,
        // or sometimes null (e.g., 20% chance of being null)
        $dateExpiry = null;
        if (rand(0, 4) !== 0) { // 80% chance of having an expiry date
            $dateExpiry = $dateNeeded->copy()->addDays(rand(30, 180));
        }

        return [
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->paragraphs(3, true), // Generates 3 paragraphs of text
            'date_needed' => $dateNeeded,
            'date_expiry' => $dateExpiry,
            'location' => $this->faker->city() . ', ' . $this->faker->stateAbbr(),
        ];
    }
}
