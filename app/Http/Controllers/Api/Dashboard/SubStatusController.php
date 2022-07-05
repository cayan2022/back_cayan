<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\StoreSubStatusRequest;
use App\Http\Requests\Api\Dashboard\UpdateSubStatusRequest;
use App\Http\Resources\SubStatusResource;
use App\Models\SubStatus;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SubStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
       return SubStatusResource::collection(SubStatus::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\Dashboard\StoreSubStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubStatusRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  SubStatus  $subStatus
     * @return SubStatusResource
     */
    public function show(SubStatus $subStatus)
    {
        return new SubStatusResource($subStatus);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\Dashboard\UpdateSubStatusRequest  $request
     * @param  SubStatus  $subStatus
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubStatusRequest $request, SubStatus $subStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  SubStatus  $subStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubStatus $subStatus)
    {
        //
    }
}
