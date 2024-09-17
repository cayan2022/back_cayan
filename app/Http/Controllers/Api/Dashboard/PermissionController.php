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
        $permissions_types = Permission::all(['id', 'name', 'type'])->groupBy('type');

        foreach ($permissions_types as $category => &$items) {
            foreach ($items as &$item) {
                $name = explode(' ', trim($item['name']));
                $item['name'] = __('Roles.' . $name[0]);
                $item['type'] = __('Roles.' . $item['type']);
            }
        }

        return response()->json(['data' => $permissions_types]);
    }

    public function user(Request $request)
    {
        return $request->user()->getAllPermissions()->pluck('name')->toArray();
    }
}
