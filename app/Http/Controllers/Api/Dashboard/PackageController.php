<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\Traits\RespondsWithHttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\StorePackageRequest;
use App\Http\Requests\Api\Dashboard\UpdatePackageRequest;
use App\Http\Resources\PackageResource;
use App\Http\Resources\PortfolioResource;
use App\Models\Package;
use App\Models\Portfolio;
use App\Http\Requests\Api\Dashboard\StorePortfolioRequest;
use App\Http\Requests\Api\Dashboard\UpdatePortfolioRequest;

class PackageController extends Controller
{
    use RespondsWithHttpStatus;

    public function index()
    {
        return PackageResource::collection(Package::latest()->paginate());
    }

    public function store(StorePackageRequest $request)
    {
        $package = Package::create($request->validated());
        return $package->getResource();
    }
    public function show(Package $package)
    {
        return $package->getResource();
    }

    public function update(UpdatePackageRequest $request, Package $package)
    {
        $package->update($request->validated());
        return $package->getResource();
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return $this->success(__('auth.success_operation'));
    }


    public function block(Package $package)
    {
        $package->block();

        return $this->success(__('auth.success_operation'));
    }

    public function active(Package $package)
    {
        $package->active();
        return $this->success(__('auth.success_operation'));
    }
}
