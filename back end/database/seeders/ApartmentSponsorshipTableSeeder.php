<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ApartmentSponsorship;

class ApartmentSponsorshipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $apartmentSponsorships = [

            [
                "start_date" => "2021-10-05",
                "end_date" => "2021-10-06"
            ],
            [
                "start_date" => "2022-05-03",
                "end_date" => "2022-05-06"
            ],
            [
                "start_date" => "2023-01-20",
                "end_date" => "2023-01-26"
            ],
        ];

        foreach ($apartmentSponsorships as $apartmentSponsorship) {

            ApartmentSponsorship :: create([
                "start_date" => $apartmentSponsorship["start_date"],
                "end_date" => $apartmentSponsorship["end_date"],
     
            ]);

        }
    }
}
