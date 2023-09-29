<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run()
    {
        // Créez trois clients avec des noms et des numéros de téléphone non nuls
        Client::create([
            'nom' => 'Client 1',
            'telephone' => '1234567890',
            'email' => 'client1@example.com',
            'prenoms' => 'Prenom 1',
        ]);

        Client::create([
            'nom' => 'Client 2',
            'telephone' => '9876543210',
            'email' => 'client2@example.com',
            'prenoms' => 'Prenom 2',
        ]);

        Client::create([
            'nom' => 'Client 3',
            'telephone' => '5555555555',
            'email' => 'client3@example.com',
            'prenoms' => 'Prenom 3',
        ]);
    }
}
