<?php

namespace Database\Seeders;

use App\Models\StatutAbsence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatutAbsenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuts = [
            [
                'nom' => 'En Attente',
                'description' => 'L\'absence est en attente d\'approbation par un gestionnaire ou un responsable.',
            ],
            [
                'nom' => 'Approuvée',
                'description' => 'L\'absence a été approuvée par un gestionnaire ou un responsable.',
            ],
            [
                'nom' => 'Refusée',
                'description' => 'L\'absence a été refusée par un gestionnaire ou un responsable.',
            ],
            [
                'nom' => 'Annulée',
                'description' => 'L\'absence a été annulée par l\'employé qui l\'a demandée.',
            ],
        ];

        foreach ($statuts as $statut) {
            StatutAbsence::create($statut);
        }
    }
}
