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
        $permissions_types = Permission::all(['id','name','type'])->groupBy('type');

        foreach ($permissions_types as $permissions_type) {
            dd($permissions_type);
            $types[] = [
                'id' => $permissions_type->id,
                'type' => $permissions_type->type,
                'permissions' => $permissions_type
            ];
        }
        return response()->json(['data' => $permissions_types]);
    }

    public function user(Request $request)
    {
        return $request->user()->getAllPermissions()->pluck('name')->toArray();
    }
}
