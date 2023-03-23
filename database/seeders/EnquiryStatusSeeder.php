<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnquiryStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $enquiry_statuses=[
            ['enquiry_status'=>'New'],
            ['enquiry_status'=>'Reviewed'],
            ['enquiry_status'=>'Invited'],
            ['enquiry_status'=>'Responded'],
        ];
        DB::table('enquiry_statuses')->insert($enquiry_statuses);
    }
}
