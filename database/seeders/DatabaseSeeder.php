<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Contracts\Container\BindingResolutionException;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function run()
    {
        /*
         * note:first before create orders you must create one record at these tables in same order:
        categories,source,branch
        also must run seeder for
        statues and substatuses
        */
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
        //the order is very important
        $this->call(
            [
                CountrySeeder::class,
                PermissionSeeder::class,
                RoleSeeder::class,
                UserSeeder::class,
                AboutSeeder::class,
                CategorySeeder::class,
                ServiceSeeder::class,//need to create one category at least before
                SettingSeeder::class,
                OfferSeeder::class,
                DoctorSeeder::class,
                SourceSeeder::class,
                BranchSeeder::class,
                StatusSeeder::class,
                SubStatusSeeder::class,
                OrderSeeder::class, //needs to add [User,Category,Source,Branch] before
                OrderHistorySeeder::class,//need to create one order at least before
                TestimonialSeeder::class,
                TidingSeeder::class,
                BlogSeeder::class,
                PartnerSeeder::class,
                ProjectSeeder::class
            ]
        );
    }
}
