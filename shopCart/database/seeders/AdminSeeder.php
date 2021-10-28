<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     'name' => Str::random(10),
        //     'email' => Str::random(10).'@gmail.com',
        //     'password' => Hash::make('password'),
        //     'admin'=>'1',
        // ]);

        DB::table('users')->insert([
            'name' => 'liou',
            'email' => 'aa78789898tw@gmail.com',
            'password' => Hash::make('password'),
            'admin'=>'1',
        ]);

    }
}
