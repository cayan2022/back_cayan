<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\StoreSourceRequest;
use App\Http\Requests\Api\Dashboard\UpdateSourceRequest;
use App\Http\Resources\SourceResource;
use App\Models\Source;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Helpers\Traits\RespondsWithHttpStatus;
class SourceController extends Controller
{

    use RespondsWithHttpStatus;
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return SourceResource::collection(Source::filter()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\Dashboard\StoreSourceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSourceRequest $request)
    {
        $source = Source::create($request->validated());

        return new SourceResource($source);
    }

    /**
     * Display the specified resource.
     *
     * @param  Source  $source
     * @return SourceResource
     */
    public function show(Source $source)
    {
        return new SourceResource($source);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\Dashboard\UpdateSourceRequest  $request
     * @param  Source  $source
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSourceRequest $request, Source $source)
    {
        $source->update($request->validated());

        return new ServiceResource($source);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Source  $source
     * @return \Illuminate\Http\Response
     */
    public function destroy(Source $source)
    {
        $source = Source::findorFail($source->id);

        $source->delete();

        return $this->success('Source Deleted Successfully');
    }
}
