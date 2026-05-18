<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed the default admin user
        \App\Models\User::factory()->create([
            'name' => 'Logbook Admin',
            'email' => 'admin@school.com',
            'password' => bcrypt('password'),
        ]);

        // Seed some mock visitor logs
        $today = now();
        $yesterday = now()->subDay();

        \App\Models\Visitor::create([
            'name' => 'John Doe',
            'purpose' => 'Deliver office supplies',
            'time_in' => $yesterday->copy()->setHour(9)->setMinute(15),
            'time_out' => $yesterday->copy()->setHour(10)->setMinute(0),
        ]);

        \App\Models\Visitor::create([
            'name' => 'Jane Smith',
            'purpose' => 'Parent-Teacher conference',
            'time_in' => $yesterday->copy()->setHour(14)->setMinute(30),
            'time_out' => $yesterday->copy()->setHour(15)->setMinute(45),
        ]);

        \App\Models\Visitor::create([
            'name' => 'Michael Johnson',
            'purpose' => 'Maintenance check on HVAC',
            'time_in' => $today->copy()->setHour(8)->setMinute(0),
            'time_out' => null, // Currently in
        ]);

        \App\Models\Visitor::create([
            'name' => 'Sarah Connor',
            'purpose' => 'Guest speaker for Science class',
            'time_in' => $today->copy()->setHour(10)->setMinute(15),
            'time_out' => $today->copy()->setHour(12)->setMinute(0), // Checked out
        ]);

        \App\Models\Visitor::create([
            'name' => 'Robert Patrick',
            'purpose' => 'IT support service',
            'time_in' => $today->copy()->setHour(11)->setMinute(30),
            'time_out' => null, // Currently in
        ]);
    }
}
