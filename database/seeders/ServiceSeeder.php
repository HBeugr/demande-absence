<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'nom' => 'Service 1',
            'description' => 'Description du Service 1',
            'prix' => 300000,
        ]);

        Service::create([
            'nom' => 'Service 2',
            'description' => 'Description du Service 2',
            'prix' => 50000,
        ]);

        Service::create([
            'nom' => 'Service 3',
            'description' => 'Description du Service 3',
            'prix' => 600000,
        ]);
    }
}
