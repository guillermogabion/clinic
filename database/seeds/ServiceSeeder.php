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
            "name" => "Oral Prophylaxis"
        ]);
        Services::create([
            "name" => "Fluoride Varnishs"
        ]);
        Services::create([
            "name" => "Tooth Restoration"
        ]);
        Services::create([
            "name" => "Tooth Extraction"
        ]);
        Services::create([
            "name" => "Dentures"
        ]);
        Services::create([
            "name" => "Whitening"
        ]);
        Services::create([
            "name" => "Gingivectomy"
        ]);
        Services::create([
            "name" => "Braces"
        ]);
    }
}
