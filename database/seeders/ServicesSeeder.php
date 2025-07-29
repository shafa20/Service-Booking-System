<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        Service::insert([
            [
                'name' => 'AC Repair',
                'description' => 'Air conditioner repair and maintenance',
                'price' => 1500.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Plumbing',
                'description' => 'Plumbing services for home and office',
                'price' => 1000.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Electrical',
                'description' => 'Electrical wiring and repair',
                'price' => 1200.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
