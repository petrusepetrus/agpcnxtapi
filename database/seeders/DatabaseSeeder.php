<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CountriesSeeder::class,
            UserSeeder::class,
            UserTypeSeeder::class,
            UserTypeStatusSeeder::class,
            RolesAndPermissionsSeeder::class,
            SuperAdminSeeder::class,
            PhoneTypeSeeder::class,
            NotificationTopicsSeeder::class,
            EnquiryTypeSeeder::class,
            EnquiryStatusSeeder::class,
            AddressTypeSeeder::class,
        ]);
    }
}
