<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $users =  [

            [
                'name'=> "Mario",
                'surname'=> "Rossi",
                'email'=> "mario.rossi@mail.com",
                'date_of_birth'=> "1990-06-15",
                'password'=> "gianmarco292",
            ],
            [
                'name'=> "Franco",
                'surname'=> "Santini",
                'email'=> "franco.santini@mail.com",
                'date_of_birth'=> "1982-01-22",
                'password'=> "ballandoconilupi23",
            ],
            [
                'name'=> "Patrizio",
                'surname'=> "Marrone",
                'email'=> "patrick.brown@mail.com",
                'date_of_birth'=> "1976-02-05",
                'password'=> "patmar029",
            ],
            [
                'name'=> "Davide",
                'surname'=> "Bassi",
                'email'=> "piccolodavide@mail.com",
                'date_of_birth'=> "1992-09-29",
                'password'=> "bassettoforlife",
            ],
        ];

        foreach ($users as $user) {

            User :: create([
                "name" => $user["name"],
                "surname" => $user["surname"],
                "email" => $user["email"],
                "date_of_birth" => $user["date_of_birth"],
                "password" => $user["password"],
            ]);

        }
    }
}
