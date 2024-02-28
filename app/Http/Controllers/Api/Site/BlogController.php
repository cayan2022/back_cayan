<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BlogController extends Controller
{
    public function __invoke(Request $request)
    {
        return BlogResource::collection(Blog::whereIsActive()->filter()->latest()->get());
    }


    public function show($slug)
    {
        $blog = Blog::Firstwhere('slug', $slug);
        return BlogResource::make($blog);
    }
}
