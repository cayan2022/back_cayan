<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreAboutRequest;
use App\Http\Requests\Api\UpdateAboutRequest;
use App\Http\Resources\AboutResource;
use App\Models\About;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return AboutResource::collection(About::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\StoreAboutRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAboutRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  About  $about
     * @return AboutResource
     */
    public function show(About $about)
    {
        return  new AboutResource($about);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\UpdateAboutRequest  $request
     * @param  About  $about
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAboutRequest $request, About $about)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  About  $about
     * @return \Illuminate\Http\Response
     */
    public function destroy(About $about)
    {
        //
    }
}
