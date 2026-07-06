<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    public function run()
    {
        Staff::firstOrCreate(
            ['staffID' => 'PG1001'],
            [
                'staffName' => 'Admin User',
                'staffIC' => '010523101126',
                'staffEmail' => 'admin@progait.com',
                'staffPass' => 'qwerty',
                'staffTel' => '0123456789',
                'staffRole' => 'admin',
                'status' => 'approved',
            ]
        );
    }
}