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
            [
                "name" => "Ascensore",           
                "description" => "Ascensore presente nel condominio", 
            ],
            [
                "name" => "Donna delle pulizie",           
                "description" => "Disponibilità pulizia appartamente 1 volta al giorno di mattina", 
            ],
            [
                "name" => "Check-in autonomo",           
                "description" => "Possibilità di accedere all'appartamento attraverso codice online", 
            ],
            [
                "name" => "Cucina",           
                "description" => "Cucina disponibile in appartamento", 
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
