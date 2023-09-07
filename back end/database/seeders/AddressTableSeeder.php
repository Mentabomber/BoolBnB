<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Address;
use App\Models\Apartment;

class AddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $addresses = [

            [    
                "latitude" => 45.62784,
                "longitude" => 13.78451,
                "street"=> "Via Vittorio Bersezio",
                "street_number" => 1,      
                "cap"=> "34146",
                "city"=> "Trieste",
                "province"=> "Trieste",
                "floor"=> 0,
            ],
            [    
                "latitude" => 44.98283,
                "longitude" => 8.98879,
                "street"=> "Via Carlo Porta",
                "street_number" => 1,      
                "cap"=> "27058",
                "city"=> "Voghera",
                "province"=> "Voghera",
                "floor"=> 2,
            ],
            [    
                "latitude" => 45.15095,
                "longitude" => 10.77882,
                "street"=> "Viale Gorizia",
                "street_number" => 20,      
                "cap"=> "46100",
                "city"=> "Mantova",
                "province"=> "Mantova",
                "floor"=> 5,
            ],
            [    
                "latitude" => 37.39843,
                "longitude" => 13.6184,
                "street"=> "Via Salvemini",
                "street_number" => 3,      
                "cap"=> "92021",
                "city"=> "Aragona",
                "province"=> "Agrigento",
                "floor"=> 2,
            ],

        ];

        for ($i=0; $i <sizeof($addresses); $i++) { 

            $data = $addresses[$i];

            $address = Address :: make([
                "latitude" => $data["latitude"],
                "longitude" => $data["longitude"],
                "street" => $data["street"],
                "street_number" => $data["street_number"],
                "cap" => $data["cap"],
                "city" => $data["city"],
                "province" => $data["province"],
                "floor" => $data["floor"]
            ]);

            $apartment = Apartment::findOrFail($i+1);

            $address -> apartment_id = $apartment -> id;
            $address -> save();
        }
    }
}
