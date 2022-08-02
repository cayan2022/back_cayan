<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\StoreServiceRequest;
use App\Http\Requests\Api\Dashboard\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Helpers\Traits\RespondsWithHttpStatus;

class ServiceController extends Controller
{

    use RespondsWithHttpStatus;
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return ServiceResource::collection(Service::filter()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreServiceRequest  $request
     * @return ServiceResource
     */
    public function store(StoreServiceRequest $request)
    {
        $service= Service::create($request->validated());
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $service->addMediaFromRequest('image')->toMediaCollection(Service::MEDIA_COLLECTION_NAME);
        }
        return $service->getResource();
    }

    /**
     * Display the specified resource.
     *
     * @param  Service  $service
     * @return ServiceResource
     */
    public function show(Service $service)
    {
        return $service->getResource();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateServiceRequest  $request
     * @param  Service  $service
     * @return ServiceResource
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service->update($request->validated());
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $service->clearMediaCollection(Service::MEDIA_COLLECTION_NAME);
            $service->addMediaFromRequest('image')->toMediaCollection(Service::MEDIA_COLLECTION_NAME);
        }
        return $service->getResource();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return $this->success(__('auth.success_operation'));
    }
    /**
     * @param  Testimonial $testimonial
     * @return \Illuminate\Http\JsonResponse
     */
    public function block(Testimonial $testimonial)
    {
        $testimonial->block();
        return response()->json(['message'=>__('auth.success_operation')]);
    }
    /**
     * @param  Testimonial $testimonial
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(Testimonial $testimonial)
    {
        $testimonial->active();
        return response()->json(['message'=>__('auth.success_operation')]);
    }
}
