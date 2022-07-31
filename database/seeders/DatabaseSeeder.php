<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('cache:forget spatie.permission.cache');
        //the order is very important
        $this->call(
            [
                CountrySeeder::class,
                PermissionSeeder::class,
                RoleSeeder::class,
                UserSeeder::class,
                AboutSeeder::class,
                CategorySeeder::class,
                ServiceSeeder::class,
                SettingSeeder::class,
                OfferSeeder::class,
                DoctorSeeder::class,
                SourceSeeder::class,
                BranchSeeder::class,
                StatusSeeder::class,
                SubStatusSeeder::class,
                OrderSeeder::class,
                OrderHistorySeeder::class,
                TestimonialSeeder::class
            ]
        );
    }
}
