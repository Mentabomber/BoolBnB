<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Message;
use App\Models\Apartment;

class MessageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $messages = [

            [
                "message" => "Ciao, sono interessato alla prenotazione del suo appartamento. Vorrei vedere se possibile qualche altra foto. Grazie in anticipo" ,            
                "name" =>  "Giuseppe",       
                "surname" =>  "Bevilacqua",    
                "email" =>  "beppe.acqua@mail.com",
            ],
        ];

        foreach ($messages as $message) {

            $message = Message :: make([
                "message" => $message["message"],
                "name" => $message["name"],
                "surname" => $message["surname"],
                "email" => $message["email"],
            ]);
            
            $apartment = Apartment::inRandomOrder() -> first();

            $message -> apartment_id = $apartment -> id;
            $message -> save();


        }
      
    }
}
