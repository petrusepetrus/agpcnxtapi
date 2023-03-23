<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name'=>'Peter',
            'last_name'=>'Stone',
            'name' => 'Peter Stone',
            'email' => 'peter.stone@agapanthus-consulting.com',
            'password' => Hash::make('S7[tD24F}kcCx]Mb1'),
        ]);
    }
}
