<?php

use App\Services;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Services::create([
            "name" => "Oral Prophylaxis",
            "duration" => "20-40 mins",
            "price" => 100
        ]);
        Services::create([
            "name" => "Fluoride Varnishs",
            "duration" => "2-5 mins",
            "price" => 100

        ]);
        Services::create([
            "name" => "Tooth Restoration",
            "duration" => "15-30 mins",
            "price" => 100

        ]);
        Services::create([
            "name" => "Tooth Extraction",
            "duration" => "5-30 mins",
            "price" => 100

        ]);
        Services::create([
            "name" => "Dentures",
            "duration" => "",
            "price" => 100


        ]);
        Services::create([
            "name" => "Whitening",
            "duration" => "60-90 mins",
            "price" => 100

        ]);
        Services::create([
            "name" => "Gingivectomy",
            "duration" => "30-60 mins",
            "price" => 100

        ]);
        Services::create([
            "name" => "Braces",
            "duration" => "2 hrs",
            "price" => 100

        ]);
    }
}
