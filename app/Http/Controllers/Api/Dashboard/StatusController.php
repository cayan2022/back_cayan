<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\StoreStatusRequest;
use App\Http\Requests\Api\Dashboard\UpdateStatusRequest;
use App\Http\Resources\StatusResource;
use App\Http\Resources\SubStatusResource;
use App\Models\Status;
use App\Models\SubStatus;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return StatusResource::collection(Status::paginate(4));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Api\Dashboard\StoreStatusRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStatusRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Status $status
     * @return StatusResource
     */
    public function show(Status $status)
    {
        return new StatusResource($status);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Api\Dashboard\UpdateStatusRequest $request
     * @param Status $status
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStatusRequest $request, Status $status)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Status $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $status)
    {
        //
    }

    public function subStatuses(Status $status)
    {
        return SubStatusResource::collection(SubStatus::where('status_id', $status->id)->paginate());
    }
}
