<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

Use App\Models\Apartment;
Use App\Models\User;
Use App\Models\Service;

class ApartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $apartments = [
            [
    
                "title" => "Appartamento rustico con giardino e Wi-fi",          
                "rooms"=> 5,      
                "beds"=> 2,       
                "bathrooms"=> 1,
                "square_meters"=> 150,
                "image"=> "1d13ba24-41ae-4349-b23d-5215385ff683.jpg",
                "visible"=> false
            ]
        ];

        foreach ($apartments as $apartment) {

            $apartment = Apartment :: make([
                "title" => $apartment["title"],
                "rooms" => $apartment["rooms"],
                "beds" => $apartment["beds"],
                "bathrooms" => $apartment["bathrooms"],
                "square_meters" => $apartment["square_meters"],
                "image" => 'storage/' . $apartment["image"],
                "visible" => $apartment["visible"],
            ]);
            
            $user = User::inRandomOrder() -> first();
            
            $apartment -> user_id = $user -> id;
            $apartment -> save();

            $services = Service::inRandomOrder() -> limit(rand(1, 6)) -> get();

            $apartment -> services() -> attach($services);

            

        }

    }
    
}
