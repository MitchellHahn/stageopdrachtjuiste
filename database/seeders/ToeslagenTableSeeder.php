<?php

namespace Database\Seeders;

use App\Models\Toeslag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
//use App\User;

class ToeslagenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Toeslag::create([
            'datum' => '2022-12-08',
            'toeslagbegintijd' => '13:41:00',
            'toeslageindtijd' => '23:41:00',
            'toeslagsoort' => 'test',
            'toeslagpercentage' => '120',
            'uurtarief' => '12',
            'userid' => '15',
        ]);
    }
}

