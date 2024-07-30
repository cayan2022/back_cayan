<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Models\BlogTag;

class BlogController extends Controller
{
    public function __invoke()
    {
        $blogs = Blog::whereIsActive()->filter()->latest()->paginate(10);
        return $this->paginateResponse(BlogResource::collection($blogs), $blogs);
    }


    public function show($slug)
    {
        $blog = Blog::Firstwhere('slug', $slug);
        return BlogResource::make($blog);
    }

    public function getBlogsByTag($tag)
    {
        $blogIds = BlogTag::where('name', $tag)->pluck('blog_id');
        $blogs = Blog::whereIn('id', $blogIds)->whereIsActive()->filter()->latest()->paginate(10);
        return $this->paginateResponse(BlogResource::collection($blogs), $blogs);
    }
}
