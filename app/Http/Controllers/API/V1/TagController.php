<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Blog\Tag;
use App\Services\TagService;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class TagController extends Controller
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = $this->tagService->paginate(10);
        return response([
            'message' => 'success',
            'tags' => TagResource::collection($tags),
            'meta' => Arr::only($tags->toArray(), ['current_page', 'from', 'to', 'last_page', 'per_page', 'total']),
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagRequest $request)
    {
        $this->tagService->create($request->validated());
        return response([
            'message' => 'success',
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = $this->tagService->find($id);
        $found = $tag ?? false;
        return response([
            'message' => '',
            'tag' => $found ? new TagResource($tag) : null,
        ], $found ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagRequest $request, $id)
    {
        $tag = $this->tagService->find($id);
        $found = $tag ?? false;
        if (!$found) {
            return response([
                'message' => 'Not found',
            ], Response::HTTP_NOT_FOUND);
        }
        $this->tagService->update($tag,$request->validated());
        $tag = $tag->fresh();

        return response([
            'message' => 'success',
            'tag' => new TagResource($tag),
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = $this->tagService->find($id);
        $found = $tag ?? false;
        if (!$found) {
            return response([
                'message' => 'Not found',
            ], Response::HTTP_NOT_FOUND);
        }
        $this->tagService->delete($tag);
        return response([
            'message' => 'success',
        ], Response::HTTP_OK);
    }
}
