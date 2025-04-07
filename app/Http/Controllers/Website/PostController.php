<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Filters\Website\PostFilter;
use App\Http\Requests\Website\PostStoreRequest;
use App\Http\Requests\Website\PostUpdateRequest;
use App\Http\Resources\Website\PostResource;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PostFilter $filters)
    {
        $posts = Post::filter($filters)->paginate(10);

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request)
    {
        $post = $request->storePost();

        return response([
            'message' => __('posts.store'),
            'post' => new PostResource($post),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response([
            'post' => new PostResource($post),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        $post->ensureOfPostOwner();
        $post = $request->updatePost();

        return response([
            'message' => __('posts.update'),
            'post' => new PostResource($post),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->ensureOfPostOwner();
        $post->remove();

        return response([
            'message' => __('posts.destroy'),
        ]);
    }
}
