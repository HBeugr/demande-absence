<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //dg
        User::create([
            'departement_id' => 4, // DG.
            'role_id' => 3, // Administrateur.
            'nom' => 'Beugré',
            'prenoms' => 'Hans',
            'email' => 'admin@admin.com',
            'password' => bcrypt('@Admin_2023'),
            'contact' => '0101633526',
            'adresse' => 'Angré',
            'genre' => 'Masculin',
        ]);

        //manager
        User::create([
            'departement_id' => 1, // informatique.
            'role_id' => 2, // manager.
            'nom' => 'Dev',
            'prenoms' => 'It',
            'email' => 'dev@dev.com',
            'password' => bcrypt('@Dev_2023'),
            'contact' => '0101533526',
            'adresse' => 'Angré',
            'genre' => 'Feminin',
        ]);

        User::create([
            'departement_id' => 2, // commercial.
            'role_id' => 2, // manager.
            'nom' => 'Commercial',
            'prenoms' => 'commercial',
            'email' => 'commercial@commercial.com',
            'password' => bcrypt('@Commercial_2023'),
            'contact' => '0101633536',
            'adresse' => 'Angré',
            'genre' => 'Masculin',
        ]);

        User::create([
            'departement_id' => 3, // communication.
            'role_id' => 2, // manager.
            'nom' => 'Communication',
            'prenoms' => 'communication',
            'email' => 'communication@communication.com',
            'password' => bcrypt('@Com_2023'),
            'contact' => '0101633516',
            'adresse' => 'Angré',
            'genre' => 'Feminin',
        ]);

        //employe
        User::create([
            'departement_id' => 1, // informatique.
            'role_id' => 1, // manager.
            'nom' => 'employe1',
            'prenoms' => 'employe1',
            'email' => 'employe1@dev.com',
            'password' => bcrypt('@Dev_2023'),
            'contact' => '0501533526',
            'adresse' => 'Angré',
            'genre' => 'Feminin',
        ]);

        User::create([
            'departement_id' => 2, // commercial.
            'role_id' => 1, // manager.
            'nom' => 'employe2',
            'prenoms' => 'employe2',
            'email' => 'employe2@commercial.com',
            'password' => bcrypt('@Commercial_2023'),
            'contact' => '0701633536',
            'adresse' => 'Angré',
            'genre' => 'Masculin',
        ]);

        User::create([
            'departement_id' => 3, // communication.
            'role_id' => 1, // manager.
            'nom' => 'employe3',
            'prenoms' => 'employe3',
            'email' => 'employe3@communication.com',
            'password' => bcrypt('@Admin_2023'),
            'contact' => '0901633516',
            'adresse' => 'Angré',
            'genre' => 'Feminin',
        ]);
    }
}
