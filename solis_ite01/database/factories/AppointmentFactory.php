<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => Student::factory(), // Creates a new Student and uses its ID
            'title' => $this->faker->sentence(3), // Generates a sentence for the title
            'appointment_date' => $this->faker->date(), // Generates a random date
            'appointment_time' => $this->faker->time(), // Generates a random time
            'status' => $this->faker->randomElement(['Pending', 'Completed']), // Randomly picks 'Pending' or 'Completed'
            'remarks' => $this->faker->paragraph(), // Generates a paragraph for remarks
        ];
    }
}
