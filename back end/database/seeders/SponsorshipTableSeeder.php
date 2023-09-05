<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Sponsorship;

class SponsorshipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sponsorships = [

            [
                "type" => "Breve",           
                "cost" => 2.99,
                "duration" => 24
            ],
            [
                "type" => "Media",           
                "cost" => 5.99,
                "duration" => 72
            ],
            [
                "type" => "Lunga",           
                "cost" => 9.99,
                "duration" => 144
            ]
        ];

        foreach ($sponsorships as $sponsorship) {

            Sponsorship :: create([
                "type" => $sponsorship["type"],
                "cost" => $sponsorship["cost"],
                "duration" => $sponsorship["duration"]
            ]); 
        }
    }
}
