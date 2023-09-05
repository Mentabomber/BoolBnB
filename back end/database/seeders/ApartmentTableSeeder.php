<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

Use App\Models\Apartment;

class ApartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $apartment= [
            [
    
                "title" => "Appartamento rustico con giardino e Wi-fi",          
                "rooms"=> 5,      
                "beds"=> 2,       
                "bathrooms"=> 1,
                "square_meters"=> 150,
                "image"=> ,
                "visible"=> ,
                "user_id"=> ,
            ]
        ];
    }
    
}
