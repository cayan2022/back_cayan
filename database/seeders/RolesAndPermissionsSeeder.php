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
            ['name' => 'Admins create', 'type' => 'Admins', 'guard_name' => 'api'],
            ['name' => 'Admins update', 'type' => 'Admins', 'guard_name' => 'api'],
            ['name' => 'Admins index', 'type' => 'Admins', 'guard_name' => 'api'],
            ['name' => 'Admins show', 'type' => 'Admins', 'guard_name' => 'api'],
            ['name' => 'Admins destroy', 'type' => 'Admins', 'guard_name' => 'api'],

            // Customers
            ['name' => 'Customers create', 'type' => 'Customers', 'guard_name' => 'api'],
            ['name' => 'Customers update', 'type' => 'Customers', 'guard_name' => 'api'],
            ['name' => 'Customers index', 'type' => 'Customers', 'guard_name' => 'api'],
            ['name' => 'Customers show', 'type' => 'Customers', 'guard_name' => 'api'],
            ['name' => 'Customers destroy', 'type' => 'Customers', 'guard_name' => 'api'],


            // Pages
            ['name' => 'Pages create', 'type' => 'Pages', 'guard_name' => 'api'],
            ['name' => 'Pages update', 'type' => 'Pages', 'guard_name' => 'api'],
            ['name' => 'Pages index', 'type' => 'Pages', 'guard_name' => 'api'],
            ['name' => 'Pages show', 'type' => 'Pages', 'guard_name' => 'api'],
            ['name' => 'Pages destroy', 'type' => 'Pages', 'guard_name' => 'api'],

            // Categories
            ['name' => 'Categories create', 'type' => 'Categories', 'guard_name' => 'api'],
            ['name' => 'Categories update', 'type' => 'Categories', 'guard_name' => 'api'],
            ['name' => 'Categories index', 'type' => 'Categories', 'guard_name' => 'api'],
            ['name' => 'Categories show', 'type' => 'Categories', 'guard_name' => 'api'],
            ['name' => 'Categories destroy', 'type' => 'Categories', 'guard_name' => 'api'],

            // Sliders
            ['name' => 'Sliders create', 'type' => 'Sliders', 'guard_name' => 'api'],
            ['name' => 'Sliders update', 'type' => 'Sliders', 'guard_name' => 'api'],
            ['name' => 'Sliders index', 'type' => 'Sliders', 'guard_name' => 'api'],
            ['name' => 'Sliders show', 'type' => 'Sliders', 'guard_name' => 'api'],
            ['name' => 'Sliders destroy', 'type' => 'Sliders', 'guard_name' => 'api'],

            // Services
            ['name' => 'Services create', 'type' => 'Services', 'guard_name' => 'api'],
            ['name' => 'Services update', 'type' => 'Services', 'guard_name' => 'api'],
            ['name' => 'Services index', 'type' => 'Services', 'guard_name' => 'api'],
            ['name' => 'Services show', 'type' => 'Services', 'guard_name' => 'api'],
            ['name' => 'Services destroy', 'type' => 'Services', 'guard_name' => 'api'],

            // Orders
            ['name' => 'Orders create', 'type' => 'Orders', 'guard_name' => 'api'],
            ['name' => 'Orders update', 'type' => 'Orders', 'guard_name' => 'api'],
            ['name' => 'Orders index', 'type' => 'Orders', 'guard_name' => 'api'],
            ['name' => 'Orders show', 'type' => 'Orders', 'guard_name' => 'api'],
            ['name' => 'Orders destroy', 'type' => 'Orders', 'guard_name' => 'api'],


            // Orders
            ['name' => 'OrdersFollow create', 'type' => 'OrdersFollow', 'guard_name' => 'api'],
            ['name' => 'OrdersFollow update', 'type' => 'OrdersFollow', 'guard_name' => 'api'],
            ['name' => 'OrdersFollow index', 'type' => 'OrdersFollow', 'guard_name' => 'api'],
            ['name' => 'OrdersFollow show', 'type' => 'OrdersFollow', 'guard_name' => 'api'],



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
        AppTables::firstOrCreate(['title' => 'Services','title_ar'=>'الخدمات ادارة', 'is_active' => 1]);
        AppTables::firstOrCreate(['title' => 'Orders','title_ar'=>'ادارةالطلبات ', 'is_active' => 1]);
        AppTables::firstOrCreate(['title' => 'Orders','title_ar'=>'ادارة متابعة الطلبات ', 'is_active' => 1]);

    }
}
