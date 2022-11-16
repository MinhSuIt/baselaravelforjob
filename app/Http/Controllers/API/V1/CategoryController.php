<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryConllection;
use App\Http\Resources\CategoryResource;
use App\Models\Blog\Category;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        // $this->middleware("can:viewAny,".Category::class)->only('index');
        $this->middleware("can:viewAny,category")->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryService->paginate(10);
        return response([
            'message' => 'success',
            'categories' => CategoryResource::collection($categories),
            'meta' => Arr::only($categories->toArray(), ['current_page', 'from', 'to', 'last_page', 'per_page', 'total']),
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
    public function store(StoreCategoryRequest $request)
    {
        $this->categoryService->create($request->validated());
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
        $category = $this->categoryService->find($id);
        $found = $category ?? false;
        return response([
            'message' => '',
            'category' => $found ? new CategoryResource($category) : null,
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
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = $this->categoryService->find($id);
        $found = $category ?? false;
        if (!$found) {
            return response([
                'message' => 'Not found',
            ], Response::HTTP_NOT_FOUND);
        }
        $this->categoryService->update($category,$request->validated());
        $category = $category->fresh();

        return response([
            'message' => 'success',
            'category' => new CategoryResource($category),
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
        $category = $this->categoryService->find($id);
        $found = $category ?? false;
        if (!$found) {
            return response([
                'message' => 'Not found',
            ], Response::HTTP_NOT_FOUND);
        }
        $this->categoryService->delete($category);
        return response([
            'message' => 'success',
        ], Response::HTTP_OK);
    }
}
