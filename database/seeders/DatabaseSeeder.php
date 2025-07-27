<?php

namespace Database\Seeders;

use App\Models\Departments;
use App\Models\Designations;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       $depart = Departments::create([
            'deparment_name' => "Informatique",
            'status_depart' => "Active",
        ]);

       $desig = Designations::create([
            'name_designation' => "Développeur mobile",
            'status_design' => "Active",
            'department_id' => $depart->depart,
        ]);

        User::create([
            'name' => "Yapi",
            'email' => "theodoreyapi@gmail.com",
            'last_name' => "n'guessan kouassi théodore",
            'photo' => "",
            'date_embauche' => "01-07-2025",
            'contrat' => "CONSULTANT",
            'doc_contrat' => "",
            'cnps' => "",
            'doc_diplome' => "",
            'salaire' => 0,
            'nationnalite' => "IVOIRIENNE",
            'type_papier' => "CNI",
            'numero_papier' => "",
            'date_naissance' => "09-11-1993",
            'lieu_naissance' => "Adzopé",
            'lieu_residence' => "Marcory résidentiel",
            'situation_matrimoniale' => "Célibataire",
            'sexe' => "Homme",
            'enfant' => 0,
            'phone' => "0585831647",
            'department_id' => $depart->depart,
            'designation_id' => $desig->design,
            'type_recru' => "Recruter",
            'role' => "Admin",
            'about' => "",
            'password' => Hash::make(1234567890),
        ]);
    }
}
