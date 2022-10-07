<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Models\Status;
use App\Models\SubStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\StatusResource;
use App\Http\Resources\SubStatusResource;
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
     * Display the specified resource.
     *
     * @param Status $status
     * @return StatusResource
     */
    public function show(Status $status): StatusResource
    {
        return new StatusResource($status);
    }

    public function substatuses(Status $status): AnonymousResourceCollection
    {
        return SubStatusResource::collection(SubStatus::where('status_id', $status->id)->paginate());
    }
}
