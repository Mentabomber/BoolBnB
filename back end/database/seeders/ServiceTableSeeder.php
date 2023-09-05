<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Service;
use App\Models\Apartment;

class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [

            [
                "name" => "WiFi",           
                "description" => "Disponibilità WiFi", 
            ],
            [
                "name" => "Posto Auto",           
                "description" => "Disponiblità posto Auto al coperto", 
            ],
            [
                "name" => "Piscina",           
                "description" => "Disponibiltà Piscina", 
            ],
            [
                "name" => "Portineria",           
                "description" => "Portineria presente mattina e pomeriggio", 
            ],
            [
                "name" => "Sauna",           
                "description" => "Sauna in casa disponibile", 
            ],
            [
                "name" => "Vista Mare",           
                "description" => "Appartamento con balcone rivolto verso il mare", 
            ],
        ];

        foreach ($services as $service) {

            Service :: create([
                "name" => $service["name"],
                "description" => $service["description"],
            ]);
        

        }

    }
}
