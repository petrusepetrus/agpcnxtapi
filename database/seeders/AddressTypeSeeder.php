<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $address_types=[
            ['address_type'=>'Home'],
            ['address_type'=>'Business'],
        ];
        DB::table('address_types')->insert($address_types);
    }
}
