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

    }

    protected function createPermissions()
    {
        $routes = Route::getRoutes()->getRoutes();

        foreach ($routes as $route) {

            if ($route->getName() !== '' && in_array('check_permissions', $route->getAction('middleware'), true)) {
                $routeName = $route->getName();

                $routeNameToArray = explode('.', $routeName);
                //get last to element of array ex: (countries index) and convert to string then make first word Capitalize
                $permissionName = implode(' ', array_splice($routeNameToArray, -2));

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
