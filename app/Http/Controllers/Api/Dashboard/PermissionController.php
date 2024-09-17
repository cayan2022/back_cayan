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
        $modifiedData = [];
        foreach ($permissions_types as $category => &$items) {
            $category = __('Roles.' . $category);
            foreach ($items as &$item) {
                $name = explode(' ', trim($item['name']));
                $item['name'] = __('Roles.' . $name[0]);
                $item['type'] = __('Roles.' . $item['type']);
            }
             $modifiedData[$category] = $items;
        }
        return response()->json(['data' => $modifiedData]);
    }

    public function user(Request $request)
    {
        return $request->user()->getAllPermissions()->pluck('name')->toArray();
    }
}
