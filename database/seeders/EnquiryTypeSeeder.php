<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnquiryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $enquiry_types=[
            ['enquiry_type'=>'New Website'],
            ['enquiry_type'=>'Redesign of Existing Website'],
            ['enquiry_type'=>'Website Maintenance'],
            ['enquiry_type'=>'Search Engine Optimisation and Digital Marketing'],
            ['enquiry_type'=>'Something Else'],
        ];
        DB::table('enquiry_types')->insert($enquiry_types);
    }
}
