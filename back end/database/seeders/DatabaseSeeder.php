<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this -> call([

            UserTableSeeder :: class,
            ServiceTableSeeder :: class,
            SponsorshipTableSeeder :: class,
            ApartmentTableSeeder :: class,
            AddressTableSeeder :: class,
            MessageTableSeeder :: class,
            VisitTableSeeder :: class
        ]);

    }
}
