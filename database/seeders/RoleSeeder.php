<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'etiquette' => 'employé',
            'description' => 'Employé',
        ]);

        Role::create([
            'etiquette' => 'manager',
            'description' => 'Manager d\'un Département',
        ]);

        Role::create([
            'etiquette' => 'administrateur',
            'description' => 'Administrateur',
        ]);
    }
}
