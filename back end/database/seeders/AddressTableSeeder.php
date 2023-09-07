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
                "latitude" => 23.62784,
                "longitude" => 10.78451,
                "street"=> "Via Gianni Morandi",
                "street_number" => 6,      
                "cap"=> "37002",
                "city"=> "Bologna",
                "province"=> "Bologna",
                "floor"=> 1,
            ],
            [    
                "latitude" => 23.62784,
                "longitude" => 10.78451,
                "street"=> "Via Giacomo Poretti",
                "street_number" => 6,      
                "cap"=> "32435",
                "city"=> "Milano",
                "province"=> "Milano",
                "floor"=> 5,
            ],
            [    
                "latitude" => 23.62784,
                "longitude" => 10.78451,
                "street"=> "Via Aldo Baglio",
                "street_number" => 6,      
                "cap"=> "37002",
                "city"=> "Bologna",
                "province"=> "Bologna",
                "floor"=> 1,
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
