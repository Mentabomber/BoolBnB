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

            AddressTableSeeder :: class,
            ApartmentTableSeeder :: class,
            // UserTableSeeder :: class,
            // MessageTableSeeder :: class,
            // VisitTableSeeder :: class,
            // ServiceTableSeeder :: class,
            // SponsorshipTableSeeder :: class

        ]);

    }
}
