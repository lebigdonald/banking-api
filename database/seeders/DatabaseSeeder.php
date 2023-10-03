<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         Customer::factory()->create([
             'name' => 'Donald NKENGFACK',
             'gender' => 'M',
             'email' => 'nkengfack96@gmail.com',
             'phone_number' => '697657064',
             'date_of_birth' => '1996-10-25',
             'place_of_birth' => 'NANGA - EBOKO',
             'status' => 'S',
             'profession' => 'Senior Software Developer',
             'identification_type' => 'ID',
             'issue_date' => '2013-11-01',
             'issue_place' => 'LT01',
         ]);

        Customer::factory()->create([
            'name' => 'NGUIMFACK Blondin',
            'gender' => 'M',
            'email' => 'nkengfackdonald@yahoo.fr',
            'phone_number' => '671319573',
            'date_of_birth' => '2000-10-25',
            'place_of_birth' => 'YAOUNDE',
            'status' => 'M',
            'profession' => 'Software Developer',
            'identification_type' => 'ID',
            'issue_date' => '2020-11-01',
            'issue_place' => 'LT01',
        ]);
    }
}
