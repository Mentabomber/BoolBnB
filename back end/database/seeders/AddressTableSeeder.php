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
                "address"=> "Via Vittorio Bersezio, 1, 34146, Trieste, TS",
                "floor"=> 0,
            ],
            [    
                "latitude" => 44.98283,
                "longitude" => 8.98879,
                "address"=> "Via Carlo Porta, 1, 27058, Voghera,	PV",
                "floor"=> 2,
            ],
            [    
                "latitude" => 45.15095,
                "longitude" => 10.77882,
                "address"=> "Viale Gorizia, 20, 46100, Mantova, MN",
                "floor"=> 5,
            ],
            [    
                "latitude" => 37.39843,
                "longitude" => 13.6184,
                "address"=> "Via Salvemini, 3, 92021, Aragona, AG",
                "floor"=> 2,
            ],

        ];

        for ($i=0; $i <sizeof($addresses); $i++) { 

            $data = $addresses[$i];

            $address = Address :: make([
                "latitude" => $data["latitude"],
                "longitude" => $data["longitude"],
                "address" => $data["street"],
                "floor" => $data["floor"]
            ]);

            $apartment = Apartment::findOrFail($i+1);

            $address -> apartment_id = $apartment -> id;
            $address -> save();
        }
    }
}
