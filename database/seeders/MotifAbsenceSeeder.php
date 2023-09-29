<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;
use App\Models\MotifAbsence;
use Illuminate\Database\Seeder;

class MotifAbsenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $motifs = [
            [
                'nom' => 'Congé de Maladie',
                'description' => 'L\'employé est en congé en raison d\'une maladie ou d\'une blessure.',
            ],
            [
                'nom' => 'Congé de Maternité/Paternité',
                'description' => 'L\'employé prend un congé en raison de la naissance d\'un enfant.',
            ],
            [
                'nom' => 'Congé de Vacances',
                'description' => 'L\'employé prend un congé pour des vacances.',
            ],
            [
                'nom' => 'Congé de Formation',
                'description' => 'L\'employé est en congé pour suivre une formation professionnelle.',
            ],
            [
                'nom' => 'Congé de Décès',
                'description' => 'L\'employé est en congé en raison du décès d\'un membre de la famille.',
            ],
            [
                'nom' => 'Congé sans solde',
                'description' => 'L\'employé prend un congé non rémunéré pour une raison personnelle.',
            ],
            [
                'nom' => 'Congé payé',
                'description' => 'L\'employé prend un congé rémunéré pour des raisons personnelles.',
            ],
        ];

        foreach ($motifs as $motif) {
            MotifAbsence::create($motif);
        }
    }
}
