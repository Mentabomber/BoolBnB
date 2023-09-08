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
                "visible"=> false
            ],
            [
                "title" => "Appartamento 2",          
                "rooms"=> 6,      
                "beds"=> 3,       
                "bathrooms"=> 2,
                "square_meters"=> 77,
                "image"=> "1694091651.jpg",
                "visible"=> false
            ],
            [
                "title" => "Appartamento 3",          
                "rooms"=> 8,      
                "beds"=> 3,       
                "bathrooms"=> 2,
                "square_meters"=> 124,
                "image"=> "1694091725.jpg",
                "visible"=> false
            ],
            [
                "title" => "Appartamento 4",          
                "rooms"=> 3,      
                "beds"=> 1,       
                "bathrooms"=> 1,
                "square_meters"=> 62,
                "image"=> "1694091783.jpg",
                "visible"=> false
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

            $services = Service::inRandomOrder() -> limit(rand(1, 6)) -> get();
            $apartment -> services() -> attach($services);

            $sponsorships = Sponsorship::inRandomOrder() -> limit(rand(1, 1)) -> get();

            $date = ["2021-10-05","2022-05-03","2023-01-20"];

            $randomDate = $date[array_rand($date)];

            $numbers = [1, 3, 6];

            $rngNumber = $numbers[array_rand($numbers)]; 

            $startSponsorshipDate = Carbon::parse($randomDate);
            $endSponsorshipDate = $startSponsorshipDate -> copy() -> addDays($rngNumber);
            $apartment -> sponsorships() -> attach($sponsorships, ['start_date'=> $startSponsorshipDate, 'end_date' => $endSponsorshipDate]);

            

        }

    }
    
}
