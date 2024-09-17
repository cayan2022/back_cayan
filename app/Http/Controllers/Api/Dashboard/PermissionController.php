<?php

namespace App\Http\Controllers\Api\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\PermissionResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PermissionController extends Controller
{
    public function all(): AnonymousResourceCollection
    {
        return PermissionResource::collection(Permission::select('id', 'name', 'type')->get());
    }

    public function types()
    {
        $types = [];
        $permissions_types = Permission::all(['id', 'name', 'type'])->groupBy('type');

        foreach ($permissions_types as $key => $permissions_type) {
            $name = explode(' ', trim($permissions_type->name));
            $types[] = [
                'id' => $permissions_type->id,
                'name' => __('Roles.' . $name[0]),
                'type' => __('Roles.' . $permissions_type->type)
            ];
        }
        return response()->json(['data' => $types]);
    }

    public function user(Request $request)
    {
        return $request->user()->getAllPermissions()->pluck('name')->toArray();
    }
}
