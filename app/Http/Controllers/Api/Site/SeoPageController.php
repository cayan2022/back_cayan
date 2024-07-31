<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Resources\BranchResource;
use App\Http\Resources\SeoPageResource;
use App\Models\Branch;
use App\Models\SeoPage;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SeoPageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return AnonymousResourceCollection
     */
    public function __invoke(): AnonymousResourceCollection
    {
        return SeoPageResource::collection(SeoPage::filter()->latest()->get());
    }
}
