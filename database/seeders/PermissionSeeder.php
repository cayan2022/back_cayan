<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AppTables;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create permissions
        $this->createPermissions();

        $this->createAppTables();
    }

    protected function createAppTables()
    {
        //this should move to it's migration to be added when table add
        AppTables::firstOrCreate(['title' => 'Admins', 'title_ar' => 'ادارة المسئولين ', 'is_active' => 1]);
        AppTables::firstOrCreate(['title' => 'Customers', 'title_ar' => 'ادارة الاعضاء', 'is_active' => 1]);
        AppTables::firstOrCreate(['title' => 'Pages', 'title_ar' => 'ادارةالصفحات', 'is_active' => 1]);
        AppTables::firstOrCreate(['title' => 'Categories', 'title_ar' => 'ادارةالاقسام ', 'is_active' => 1]);
        AppTables::firstOrCreate(['title' => 'Sliders', 'title_ar' => 'ادارةالسليدرز ', 'is_active' => 1]);
        AppTables::firstOrCreate(['title' => 'Servcies', 'title_ar' => 'الخدمات ادارة', 'is_active' => 1]);
        AppTables::firstOrCreate(['title' => 'Orders', 'title_ar' => 'ادارةالطلبات ', 'is_active' => 1]);
        AppTables::firstOrCreate(['title' => 'Orders', 'title_ar' => 'ادارة متابعة الطلبات ', 'is_active' => 1]);
    }

    protected function createPermissions()
    {
        $routes = Route::getRoutes()->getRoutes();

        foreach ($routes as $route) {

            if ($route->getName() !== '' && in_array('check_permissions', $route->getAction('middleware'), true)) {
                $routeName = $route->getName();

                $routeNameToArray = explode('.', $routeName);
                //get last to element of array ex: (countries index) and convert to string then make first word Capitalize
                $permissionName = Str::ucfirst(implode(' ', array_splice($routeNameToArray, -2)));

                $permission = Permission::where('name', $permissionName)->first();

                if (is_null($permission)) {
                    permission::create(
                        ['name' => $permissionName, 'type' => Str::words($permissionName, 1,''), 'guard_name' => 'api']
                    );
                }
            }
        }
    }
}
