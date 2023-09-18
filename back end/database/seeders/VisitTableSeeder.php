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
        $visits = Visit :: factory()->count(100)->make();
            
        foreach ($visits as $visit) {

            
            $apartment = Apartment::inRandomOrder() -> first();

            $visit -> apartment_id = $apartment -> id;
            $visit -> save();


        }

    }
}
