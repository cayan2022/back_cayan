<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AssignRoleToUserRequest;
use App\Http\Requests\Api\RoleRequest;
use App\Http\Requests\Api\PermissionRequest;
use App\Models\AppTables;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function getRoles()
    {
        $roles = Role::select('id', 'name', 'guard_name')->get();
        return response()->json(['data' => $roles]);
    }

    public function getPermissions()
    {
        $permissions = Permission::select('id', 'name', 'type', 'guard_name')->get();
        return response()->json(['data' => $permissions]);
    }

    public function getRolePermissions()
    {
        $permissions = Permission::all();
        $tables = AppTables::whereIsActive(1)->pluck('title')->toArray();
        $title_pre = [];
        foreach ($tables as $iValue) {
            foreach ($permissions as $permission) {
                if ($iValue == $permission->type) {
                    $title_pre[$iValue][] = $permission->name;
                }
            }
        }
        return response()->json(['data' => $title_pre]);
    }


    public function addPermission(PermissionRequest $request)
    {
        Permission::create($request->validated() + ['guard_name' => 'api']);
        return response()->json([
            'data' => 'Permission added successfully'
        ]);

    }

    /**
     *
     * add new Role with selected permissions
     *
     * @param string $name The object to convert
     * @param array $requested_permissions The object to convert
     * @return   string
     *
     */
    public function addRole(RoleRequest $request)
    {
        $role = Role::create(['name' => $request->name, 'guard_name' => 'api']);
        $requested_permissions = (array)$request->requested_permissions;
        foreach ($requested_permissions as $key => $val) {
            $permission = Permission::where('guard_name', 'api')->where('id', $val)->firstOrFail();
            $permission->assignRole($role);
        }
        return response()->json([
            'data' => 'Role added successfully'
        ]);

    }

    /**
     *
     * assign role with selected permissions to specific user
     *
     * @param string $role The object to convert
     * @param integer $user_id The object to convert
     * @return   string
     *
     */
    public function assignRoleToUser(AssignRoleToUserRequest $request)
    {
        $role_id = $request->role_id;
        $role = Role::whereId($role_id)->firstOrFail();
        if ($role) {
            $role_permission = $role->permissions;
            $role->givePermissionTo($role_permission);
            $user = User::where('id', $request->user_id)->firstOrFail();
            $user->assignRole($role);
            return response()->json([
                'data' => 'Assign role added To user successfully'
            ]);
        }
        return response()->json([
            'data' => 'Role Not Founded'
        ], 404);


    }
}
