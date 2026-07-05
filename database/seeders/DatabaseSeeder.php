<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();



        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        // Seed an admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'), // Default password
        ]);

        // Seed a patient admin user (login with IC and password)
        \App\Models\Patient::create([
            'patientName' => 'Admin Patient',
            'patientIC' => '900101011111',
            'patientEmail' => 'adminpatient@example.com',
            'patientTel' => '0123456789',
            'patientPass' => 'admin123', // Will be hashed by mutator
        ]);

        $this->call(StaffSeeder::class);  // <-- Add this line to run your StaffSeeder
        $this->call(\Database\Seeders\ProstheticComponentSeeder::class); // Add ProstheticComponentSeeder
    }
}
