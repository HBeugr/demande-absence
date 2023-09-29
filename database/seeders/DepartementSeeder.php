<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Departement;

class DepartementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Departement::create([
            'nom' => 'informatique',
            'description' => 'Département Informatique',
        ]);

        Departement::create([
            'nom' => 'commercial',
            'description' => 'Département Commercial',
        ]);

        Departement::create([
            'nom' => 'communication',
            'description' => 'Département Communication',
        ]);

        Departement::create([
            'nom' => 'Direction',
            'description' => 'Direction Génrérale',
        ]);
    }
}
