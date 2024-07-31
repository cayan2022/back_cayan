<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Requests\Api\Dashboard\StoreSeoPageRequest;
use App\Http\Requests\Api\Dashboard\UpdateSeoPageRequest;
use App\Http\Resources\SeoPageResource;
use App\Models\SeoPage;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\BranchResource;
use App\Helpers\Traits\RespondsWithHttpStatus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SeoPageController extends Controller
{

    use RespondsWithHttpStatus;

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return SeoPageResource::collection(SeoPage::filter()->latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreBranchRequest  $request
     * @return SeoPageResource
     */
    public function store(StoreSeoPageRequest $request): SeoPageResource
    {
        $seoPage = SeoPage::create($request->validated());
        return $seoPage->getResource();
    }

    /**
     * Display the specified resource.
     *
     * @param  SeoPage  $seoPage
     * @return SeoPageResource
     */
    public function show(SeoPage $seoPage): SeoPageResource
    {
        return $seoPage->getResource();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateSeoPageRequest  $request
     * @param  SeoPage $seoPage
     * @return SeoPageResource
     */
    public function update(UpdateSeoPageRequest $request, SeoPage $seoPage)
    {
        $seoPage->update($request->validated());

        return $seoPage->getResource();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  SeoPage $seoPage
     * @return Response
     */
    public function destroy(SeoPage $seoPage): Response
    {
        $seoPage->delete();
        return $this->success(__('auth.success_operation'));
    }
}
