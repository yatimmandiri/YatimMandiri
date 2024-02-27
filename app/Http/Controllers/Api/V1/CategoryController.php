<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Collection\CategoryCollection;
use App\Http\Resources\Resource\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('categories_name', 'LIKE', '%' . $request->search . '%');
                $query->orWhere('categories_slug', 'LIKE', '%' . $request->search . '%');
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('categories_status', $request->status);
            })
            ->when($request->populer, function ($query) use ($request) {
                $query->where('categories_populer', $request->populer);
            });


        if ($request->per_page) {
            $categories = $query->paginate($request->per_page);
            $categoriesResource = new CategoryCollection($categories);
        } else {
            $categories = $query->get();
            $categoriesResource = CategoryResource::collection($categories);
        }

        return $this->sendResponse($categoriesResource, 'Get Data Successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $categoriesResource = CategoryResource::make($category);
        return $this->sendResponse($categoriesResource, 'Get Data Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }

    public function restore($id)
    {
        Category::withTrashed()->find($id)->restore();
        return $this->sendResponse([], 'Restore Data Successfully');
    }

    public function status(Category $category)
    {
        if ($category->categories_status == 'Y') {
            $category->categories_status = 'N';
        } else {
            $category->categories_status = 'Y';
        }

        $category->save();
        $categoriesResource = CategoryResource::make($category);

        return $this->sendResponse($categoriesResource, 'Update Status Successfully');
    }

    public function populer(Category $category)
    {
        $categories = Category::find($category->id);

        if ($category->categories_populer == 'Y') {
            $categories->categories_populer = 'N';
        } else {
            $categories->categories_populer = 'Y';
        }

        $categories->save();
        $categoriesResource = CategoryResource::make($category);

        return $this->sendResponse($categoriesResource, 'Update Status Successfully');
    }
}
