<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Carbon\Carbon;

Use App\Models\Apartment;
Use App\Models\User;
Use App\Models\Service;
use App\Models\Sponsorship;

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
                "image"=> "1694091577.jpg",
                "visible"=> true
            ],
            [
                "title" => "Casa Frontemare con accesso al mare esclusivo",          
                "rooms"=> 6,      
                "beds"=> 3,       
                "bathrooms"=> 2,
                "square_meters"=> 77,
                "image"=> "1694091651.jpg",
                "visible"=> true
            ],
            [
                "title" => "Villa indipendente con discesa privata al mare",          
                "rooms"=> 8,      
                "beds"=> 3,       
                "bathrooms"=> 2,
                "square_meters"=> 124,
                "image"=> "1694091725.jpg",
                "visible"=> true
            ],
            [
                "title" => "Le Lagore - Incredibile fattoria CinqueTerre restaurata",          
                "rooms"=> 3,      
                "beds"=> 1,       
                "bathrooms"=> 1,
                "square_meters"=> 62,
                "image"=> "1694091783.jpg",
                "visible"=> true
            ],
            [
                "title" => "SUBLIME 2 VANI DESIGN, NUOVO, TERRAZZA E GARAGE",          
                "rooms"=> 3,      
                "beds"=> 1,       
                "bathrooms"=> 1,
                "square_meters"=> 62,
                "image"=> "1694091783.jpg",
                "visible"=> true
            ],
            [
                "title" => "La Piazzetta sul Mare",          
                "rooms"=> 6,      
                "beds"=> 3,       
                "bathrooms"=> 2,
                "square_meters"=> 100,
                "image"=> "1694091783.jpg",
                "visible"=> true
            ],
            [
                "title" => "Casa con vista Pietra Ligure",          
                "rooms"=> 6,      
                "beds"=> 3,       
                "bathrooms"=> 2,
                "square_meters"=> 121,
                "image"=> "1694091783.jpg",
                "visible"=> true
            ],
            [
                "title" => "In un uliveto sul mare con piscina",          
                "rooms"=> 4,      
                "beds"=> 3,       
                "bathrooms"=> 2,
                "square_meters"=> 75,
                "image"=> "1694091783.jpg",
                "visible"=> true
            ],
            [
                "title" => "SanFra home/ Chiavari 5 min a piedi dal lungomare",          
                "rooms"=> 4,      
                "beds"=> 2,       
                "bathrooms"=> 1,
                "square_meters"=> 62,
                "image"=> "1694091783.jpg",
                "visible"=> true
            ],
            [
                "title" => "Zion EcoCabin: vasca idromassaggio privata, vista sullo Zion Canyon",          
                "rooms"=> 5,      
                "beds"=> 2,       
                "bathrooms"=> 1,
                "square_meters"=> 80,
                "image"=> "1694091783.jpg",
                "visible"=> true
            ],

            

        ];

        foreach ($apartments as $apartment) {

            $apartment = Apartment :: make([
                "title" => $apartment["title"],
                "rooms" => $apartment["rooms"],
                "beds" => $apartment["beds"],
                "bathrooms" => $apartment["bathrooms"],
                "square_meters" => $apartment["square_meters"],
                "image" => $apartment["image"],
                "visible" => $apartment["visible"]
            ]);
            
            $user = User::inRandomOrder() -> first();

            $apartment -> user_id = $user -> id;
            $apartment -> save();

            $services = Service::inRandomOrder() -> limit(rand(1, 10)) -> get();
            $apartment -> services() -> attach($services);

            $sponsorships = Sponsorship::inRandomOrder() -> limit(rand(0, 1)) -> get();

            $date = ["2023-09-20","2023-09-20","2023-09-20"];

            $randomDate = $date[array_rand($date)];

            $numbers = [1, 3, 6];

            $rngNumber = $numbers[array_rand($numbers)]; 

            $startSponsorshipDate = Carbon::parse($randomDate);
            $endSponsorshipDate = $startSponsorshipDate -> copy() -> addDays($rngNumber);
            $apartment -> sponsorships() -> attach($sponsorships, ['start_date'=> $startSponsorshipDate, 'end_date' => $endSponsorshipDate]);

            

        }

    }
    
}
