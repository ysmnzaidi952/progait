<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProstheticComponent;

class ProstheticComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProstheticComponent::insert([
            [
                'name' => 'Titanium Knee Joint',
                'type' => 'knee',
                'size' => 'Medium',
                'compatibility' => 'Above Knee',
                'material' => 'Titanium',
                'weight_limit' => 120,
                'description' => 'Durable titanium knee joint for above-knee prosthetics.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Carbon Fiber Foot',
                'type' => 'foot',
                'size' => 'Large',
                'compatibility' => 'Below Knee',
                'material' => 'Carbon Fiber',
                'weight_limit' => 100,
                'description' => 'Lightweight carbon fiber foot for high activity users.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gel Liner',
                'type' => 'liner',
                'size' => 'Small',
                'compatibility' => 'Below Knee, Pediatric',
                'material' => 'Gel',
                'weight_limit' => 60,
                'description' => 'Comfortable gel liner for sensitive skin.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Socket B',
                'type' => 'socket',
                'size' => 'Standard',
                'compatibility' => 'Transhumeral',
                'material' => 'Polypropylene',
                'weight_limit' => 120,
                'description' => 'Socket B for Transhumeral patients.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Suspension C',
                'type' => 'suspension',
                'size' => 'Standard',
                'compatibility' => 'Transhumeral',
                'material' => 'Nylon',
                'weight_limit' => 120,
                'description' => 'Suspension C system for Transhumeral cases.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Knee Mech D',
                'type' => 'knee',
                'size' => 'Medium',
                'compatibility' => 'Transhumeral',
                'material' => 'Aluminum',
                'weight_limit' => 120,
                'description' => 'Knee mechanism D for Transhumeral use.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pylon E',
                'type' => 'pylon',
                'size' => 'Adjustable',
                'compatibility' => 'Transhumeral',
                'material' => 'Stainless Steel',
                'weight_limit' => 130,
                'description' => 'Pylon E compatible with Transhumeral prosthetics.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Foot Y',
                'type' => 'foot',
                'size' => 'Large',
                'compatibility' => 'Transhumeral',
                'material' => 'Carbon Fiber',
                'weight_limit' => 100,
                'description' => 'Foot type Y for high function Transhumeral users.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
