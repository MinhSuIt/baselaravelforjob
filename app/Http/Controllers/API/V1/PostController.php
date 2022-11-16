<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Blog\Post;
use App\Services\CategoryService;
use App\Services\PostService;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->postService->paginate(10);
        return response([
            'message' => 'success',
            'posts' => PostResource::collection($posts),
            'meta' => Arr::only($posts->toArray(), ['current_page', 'from', 'to', 'last_page', 'per_page', 'total']),
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request, CategoryService $categoryService, TagService $tagService)
    {
        // return request()->all();
        try {
            $input = $request->validated();
            $postInput = Arr::get($input, 'post');
            $tagSyncInput = Arr::get($input, 'tags');
            $categorySyncInput = Arr::get($input, 'categories');
            // $tagData = Arr::get($input, 'tagData');
            // $categoryData = Arr::get($input, 'categoryData');

            $post = $this->postService->create($postInput);
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $post
                    ->addMedia($request->file('image'))
                    ->toMediaCollection('thumbnail');
            }
            // case tạo mới rồi sync
            // if ($tagData) {
            //     $categoryService->create($categoryData);
            // }
            // if ($categoryData) {
            //     $tagService->create($tagData);
            // }
            if ($categorySyncInput) {
                $post->categories()->sync($categorySyncInput);
            }
            if ($tagSyncInput) {
                $post->tags()->sync($tagSyncInput);
            }
            return response([
                'message' => 'success',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = $this->postService->find($id);
        $found = $post ?? false;
        return response([
            'message' => 'success',
            'post' => $found ? new PostResource($post) : null,
        ], $found ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, $id)
    {
        try {
            $input = $request->validated();
            return $input;
            $postInput = Arr::get($input, 'post');
            $categorySyncInput = Arr::get($input, 'categories');
            $tagSyncInput = Arr::get($input, 'tags');


            $post = $this->postService->find($id);
            return $input;
            return $post;
            $found = $post ?? false;
            if (!$found) {
                return response([
                    'message' => 'Not found',
                ], Response::HTTP_NOT_FOUND);
            }
            $this->postService->update($post, $postInput);

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $post->clearMediaCollection('images');

                $post
                    ->addMedia($request->file('image'))
                    ->toMediaCollection('thumbnail');
            }
            if ($categorySyncInput) {
                $post->categories()->sync($categorySyncInput);
            }
            if ($tagSyncInput) {
                $post->tags()->sync($tagSyncInput);
            }
            $post->load('media', 'categories', 'tags');
            return response([
                'message' => 'success',
                'post' => new PostResource($post),
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = $this->postService->find($id);
        $found = $post ?? false;
        if (!$found) {
            return response([
                'message' => 'Not found',
            ], Response::HTTP_NOT_FOUND);
        }
        $this->postService->delete($post);
        return response([
            'message' => 'success',
        ], Response::HTTP_OK);
    }
}
