<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * @var Repository|Application|mixed
     */
    private $count;

    public function __construct()
    {
        $this->count=config('database.seeder_count');
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createRoles();
    }
    protected function createRoles(){
        $routes = Route::getRoutes()->getRoutes();

        foreach ($routes as $route) {
            if ($route->getName() !== '' && in_array('check_permissions', $route->getAction('middleware'), true)) {
                $routeName = $route->getName();

                $routeNameToArray = explode('.', $routeName);
                //get last to element of array ex: (countries index) and convert to string then make first word Capitalize
                $permissionName = implode(' ', array_splice($routeNameToArray, -2));
                $roleName=Str::words($permissionName, 1,'');
                $findRole = Role::where('name', $roleName)->first();

                if (is_null($findRole)) {
                    $role=Role::create(
                        ['name' => $roleName, 'guard_name' => 'api']
                    );
                    $role->syncPermissions(Permission::whereType($roleName)->get());
                }
            }
        }
    }
}
