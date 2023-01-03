<?php

namespace Database\Seeders;

use Hash;
use Illuminate\Database\Seeder;
use App\Models\User;
use Str;

class UsersTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
//        User::create([
//            'name'              => 'Abdul Abdul',
//            'email'             => 'john_smith@gmail.com',
//            'password'          => Hash::make('password'),
//            'debnummer'         =>  '666',
//            'remember_token'    => Str::random(10),
//        ]);

        User::create([
            'name'              => 'Jan',
            'achternaam'        => 'Tester',
            'email'             => 'jan_tester@gmail.com',
            'password'          => Hash::make('password'),
            'remember_token'    => Str::random(10),
            'tussenvoegsel'     => 'test',
            'straat'            => 'test',
            'huisnummer'        => '5',
            'toevoeging'        => 'test',
            'postcode'          => 'test',
            'stad'              => 'test',
            'land'              => 'test',
            'telefoonnumer'     => '11646543',
            'account_type'     => '1',

        ]);

    }
}
