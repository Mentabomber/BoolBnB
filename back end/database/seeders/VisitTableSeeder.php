<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Visit;
use App\Models\Apartment;


class VisitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $visits = [

            [
                "visit_date" => "2022-03-15" ,         
                "ip_address" => "126.132.123.009" 
            ],
            [
                "visit_date" => "2022-08-12" ,         
                "ip_address" => "192.152.0.1" 
            ],
            [
                "visit_date" => "2022-08-12" ,         
                "ip_address" => "192.168.0.15" 
            ],

        ];
        foreach ($visits as $visit) {

            $visit = Visit :: make([
                "visit_date" => $visit["visit_date"],
                "ip_address" => $visit["ip_address"]
            ]);
            
            $apartment = Apartment::inRandomOrder() -> first();

            $visit -> apartment_id = $apartment -> id;
            $visit -> save();


        }

    }
}
