<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhoneTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $phone_types=[
            ['phone_type'=>'Home'],
            ['phone_type'=>'Business'],
            ['phone_type'=>'Mobile'],
        ];
        DB::table('phone_types')->insert($phone_types);
    }
}
