<?php

namespace Database\Seeders;

use App\Models\Tijd;
use App\Models\Toeslag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
//use App\User;

class TijdTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Tijd::create([
            'datum'              => '2022-12-08',
            'begintijd'             => '13:41:00',
            'eindtijd'          => '23:41:00',

        ]);
    }
}

