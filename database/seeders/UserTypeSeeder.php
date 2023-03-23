<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types=[
            ['user_type'=>'Owner','user_type_description'=>'Business owner of the application'],
            ['user_type'=>'Client','user_type_description'=>'Existing client'],
            ['user_type'=>'Prospect','user_type_description'=>'Prospective client'],
            ['user_type'=>'Guest','user_type_description'=>'Guest'],
        ];
        DB::table('user_types')->insert($types);
    }
}
