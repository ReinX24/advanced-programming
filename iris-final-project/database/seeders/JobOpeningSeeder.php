<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobOpeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 50 job openings using the factory
        JobOpening::factory()->count(50)->create();

        $this->command->info('50 job openings seeded successfully!');
    }
}
