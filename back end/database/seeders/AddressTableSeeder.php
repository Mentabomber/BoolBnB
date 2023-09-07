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

        ];
        foreach ($addresses as $address) {

            $adress = Address :: make([
                "latitude" => $address["latitude"],
                "longitude" => $address["longitude"],
                "street" => $address["street"],
                "street_number" => $address["street_number"],
                "cap" => $address["cap"],
                "city" => $address["city"],
                "province" => $address["province"],
                "floor" => $address["floor"]
            ]);

                 
            $apartment = Apartment::inRandomOrder() -> first();

            $adress -> apartment_id = $apartment -> id;
            $adress -> save();

        }
    }
}
