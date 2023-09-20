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
            [    
                "latitude" => 45.80199, 
                "longitude" => 13.52765,
                "address"=> "Via Cellottini, 15, 34074, Monfalcone, GO",
                "floor"=> 1,
            ],
            [    
                "latitude" => 38.16115,
                "longitude" => 13.32632,
                "address"=> "Via San Lorenzo, 132, 90146 , Palermo, PA",
                "floor"=> 2,
            ],
            [    
                "latitude" => 41.91513,
                "longitude" => 12.54910,
                "address"=> "Via dei Monti Tiburtini, 619, 00157 Roma, RM",
                "floor"=> 3,
            ],
            [    
                "latitude" => 37.39843,
                "longitude" => 13.6184,
                "address"=> "Via Salvemini, 3, 92021, Aragona, AG",
                "floor"=> 2,
            ],
            [    
                "latitude" => 37.30625,
                "longitude" => 13.59200,
                "address"=> "Viale della Vittoria, 231, 92100 Agrigento, AG",
                "floor"=> 2,
            ],
            [    
                "latitude" => 37.30752,
                "longitude" => 13.65435,
                "address"=> "Viale John Fitzgerald Kennedy, 42, 92026 Favara AG  5527355665, 3823882383",
                "floor"=> 6,
            ],


        ];

        for ($i=0; $i <sizeof($addresses); $i++) { 

            $data = $addresses[$i];

            $address = Address :: make([
                "latitude" => $data["latitude"],
                "longitude" => $data["longitude"],
                "address" => $data["address"],
                "floor" => $data["floor"]
            ]);

            $apartment = Apartment::findOrFail($i+1);

            $address -> apartment_id = $apartment -> id;
            $address -> save();
        }
    }
}
