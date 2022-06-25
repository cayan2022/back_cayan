<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AppTables;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class ]->forgetCachedPermissions();

        // create permissions
        $data = [

            // Admin
            ['name' => 'Admins create', 'type' => 'Admins', 'guard_name' => 'web'],
            ['name' => 'Admins update', 'type' => 'Admins', 'guard_name' => 'web'],
            ['name' => 'Admins list', 'type' => 'Admins', 'guard_name' => 'web'],
            ['name' => 'Admins show', 'type' => 'Admins', 'guard_name' => 'web'],
            ['name' => 'Admins delete', 'type' => 'Admins', 'guard_name' => 'web'],

            // Customers
            ['name' => 'Customers create', 'type' => 'Customers', 'guard_name' => 'web'],
            ['name' => 'Customers update', 'type' => 'Customers', 'guard_name' => 'web'],
            ['name' => 'Customers list', 'type' => 'Customers', 'guard_name' => 'web'],
            ['name' => 'Customers show', 'type' => 'Customers', 'guard_name' => 'web'],
            ['name' => 'Customers delete', 'type' => 'Customers', 'guard_name' => 'web'],


            // Pages
            ['name' => 'Pages create', 'type' => 'Pages', 'guard_name' => 'web'],
            ['name' => 'Pages update', 'type' => 'Pages', 'guard_name' => 'web'],
            ['name' => 'Pages list', 'type' => 'Pages', 'guard_name' => 'web'],
            ['name' => 'Pages show', 'type' => 'Pages', 'guard_name' => 'web'],
            ['name' => 'Pages delete', 'type' => 'Pages', 'guard_name' => 'web'],

            // Categories
            ['name' => 'Categories create', 'type' => 'Categories', 'guard_name' => 'web'],
            ['name' => 'Categories update', 'type' => 'Categories', 'guard_name' => 'web'],
            ['name' => 'Categories list', 'type' => 'Categories', 'guard_name' => 'web'],
            ['name' => 'Categories show', 'type' => 'Categories', 'guard_name' => 'web'],
            ['name' => 'Categories delete', 'type' => 'Categories', 'guard_name' => 'web'],

            // Sliders
            ['name' => 'Sliders create', 'type' => 'Sliders', 'guard_name' => 'web'],
            ['name' => 'Sliders update', 'type' => 'Sliders', 'guard_name' => 'web'],
            ['name' => 'Sliders list', 'type' => 'Sliders', 'guard_name' => 'web'],
            ['name' => 'Sliders show', 'type' => 'Sliders', 'guard_name' => 'web'],
            ['name' => 'Sliders delete', 'type' => 'Sliders', 'guard_name' => 'web'],

            // Servcies
            ['name' => 'Servcies create', 'type' => 'Servcies', 'guard_name' => 'web'],
            ['name' => 'Servcies update', 'type' => 'Servcies', 'guard_name' => 'web'],
            ['name' => 'Servcies list', 'type' => 'Servcies', 'guard_name' => 'web'],
            ['name' => 'Servcies show', 'type' => 'Servcies', 'guard_name' => 'web'],
            ['name' => 'Servcies delete', 'type' => 'Servcies', 'guard_name' => 'web'],

            // Orders
            ['name' => 'Orders create', 'type' => 'Orders', 'guard_name' => 'web'],
            ['name' => 'Orders update', 'type' => 'Orders', 'guard_name' => 'web'],
            ['name' => 'Orders list', 'type' => 'Orders', 'guard_name' => 'web'],
            ['name' => 'Orders show', 'type' => 'Orders', 'guard_name' => 'web'],
            ['name' => 'Orders delete', 'type' => 'Orders', 'guard_name' => 'web'],


            // Orders
            ['name' => 'OrdersFollow create', 'type' => 'OrdersFollow', 'guard_name' => 'web'],
            ['name' => 'OrdersFollow update', 'type' => 'OrdersFollow', 'guard_name' => 'web'],
            ['name' => 'OrdersFollow list', 'type' => 'OrdersFollow', 'guard_name' => 'web'],
            ['name' => 'OrdersFollow show', 'type' => 'OrdersFollow', 'guard_name' => 'web'],


        ];
        foreach ($data as $datum) {
            Permission::firstOrCreate($datum);
        }

        $this->createAppTables();
    }

    protected function createAppTables()
    {
        AppTables::firstOrCreate(['title' => 'Admins','title_ar'=>'ادارة المسئولين ', 'is_active' => 1]);
        AppTables::firstOrCreate(['title' => 'Customers', 'title_ar'=>'ادارة الاعضاء','is_active' => 1]);
        AppTables::firstOrCreate(['title' => 'Pages','title_ar'=>'ادارةالصفحات', 'is_active' => 1]);
        AppTables::firstOrCreate(['title' => 'Categories','title_ar'=>'ادارةالاقسام ', 'is_active' => 1]);
        AppTables::firstOrCreate(['title' => 'Sliders','title_ar'=>'ادارةالسليدرز ', 'is_active' => 1]);
        AppTables::firstOrCreate(['title' => 'Servcies','title_ar'=>'الخدمات ادارة', 'is_active' => 1]);
        AppTables::firstOrCreate(['title' => 'Orders','title_ar'=>'ادارةالطلبات ', 'is_active' => 1]);
        AppTables::firstOrCreate(['title' => 'Orders','title_ar'=>'ادارة متابعة الطلبات ', 'is_active' => 1]);



    }
}
