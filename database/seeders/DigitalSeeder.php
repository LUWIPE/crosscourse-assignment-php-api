<?php

namespace Database\Seeders;

use App\Models\Digital;
use Illuminate\Database\Seeder;

class DigitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Digital::factory()->create(['name' => 'yes']);
        Digital::factory()->create(['name' => 'no']);
    }
}
