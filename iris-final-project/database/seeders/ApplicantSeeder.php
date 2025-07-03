<?php

namespace Database\Seeders;

use App\Models\Applicant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 50 applicant records using the factory
        Applicant::factory(50)->create();

        $this->command->info('Created 50 applicant records.');
    }
}
