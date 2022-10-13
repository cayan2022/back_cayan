<?php

namespace App\Http\Controllers\Api\Site;

use App\Models\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     */
    public function __invoke()
    {
        return  Category::with('services')->whereIsActive()->filter()->latest()->paginate();
    }
}
