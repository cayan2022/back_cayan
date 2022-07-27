<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\StoreTestimonialRequest;
use App\Http\Requests\Api\Dashboard\UpdateTestimonialRequest;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return TestimonialResource::collection(Testimonial::when(request()->filled('name'),function ($query){
             $query->where('name','like'.'%'.request('name'),'%');
        })->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\Dashboard\StoreTestimonialRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTestimonialRequest $request)
    {
        $testimonial=Testimonial::create($request->validated());
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $testimonial->addMediaFromRequest('image')->toMediaCollection(Testimonial::MEDIA_COLLECTION_NAME);
        }
        return $testimonial->getResource();
    }

    /**
     * Display the specified resource.
     *
     * @param  Testimonial  $testimonial
     * @return TestimonialResource
     */
    public function show(Testimonial $testimonial)
    {
        return $testimonial->getResource();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTestimonialRequest  $request
     * @param  Testimonial  $testimonial
     * @return TestimonialResource
     */
    public function update(UpdateTestimonialRequest $request, Testimonial $testimonial)
    {
        $testimonial->update($request->validated());

        if($request->hasFile('image') && $request->file('image')->isValid()){
            $testimonial->clearMediaCollection(Testimonial::MEDIA_COLLECTION_NAME);
            $testimonial->addMediaFromRequest('image')->toMediaCollection(Testimonial::MEDIA_COLLECTION_NAME);
        }

        return $testimonial->getResource();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->forceDelete();
        return response()->noContent();
    }
}
