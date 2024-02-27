<?php

namespace App\Http\Controllers\Master;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\Resource\CategoryResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDataTable $datatable)
    {
        $data['pageTitle'] = 'Categories List';
        return $datatable->render('master.categories.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['pageTitle'] = 'Categories Create';
        return view('master.categories.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        if ($request->hasFile('categories_icon') && $request->file('categories_icon')->isValid()) {
            $categories_icon = $request->file('categories_icon')->store('uploads', 'public');
        } else {
            $categories_icon = null;
        }

        if ($request->hasFile('categories_featureimage') && $request->file('categories_featureimage')->isValid()) {
            $categories_featureimage = $request->file('categories_featureimage')->store('uploads', 'public');
        } else {
            $categories_featureimage = null;
        }

        $defaultValue = [
            'categories_title' => Str::title($request->categories_name),
            'categories_slug' => Str::slug($request->categories_name, '-'),
            'categories_excerpt' => Str::limit(strip_tags($request->categories_description), 100),
            'categories_icon' => $categories_icon,
            'categories_featureimage' => $categories_featureimage,
        ];

        $categories = Category::create(array_merge($request->all(), $defaultValue));

        $categoriesResource = CategoryResource::make($categories);

        return $this->sendResponse($categoriesResource, 'Insert Data Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $data['pageTitle'] = 'Categories Show';
        $data['category'] = $category;
        return view('master.categories.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $data['pageTitle'] = 'Categories Update';
        $data['category'] = $category;
        return view('master.categories.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->categories_name = $request->categories_name;
        $category->categories_description = $request->categories_description;
        $category->categories_excerpt = Str::limit(strip_tags($request->categories_description), 100);
        $category->categories_title = Str::title($request->categories_name);
        $category->categories_slug = Str::slug($request->categories_name, '-');

        if ($request->hasFile('categories_icon') && $request->file('categories_icon')->isValid()) {
            if ($category->categories_featureimage != null || $category->categories_featureimage != '') {
                Storage::disk('public')->delete($category->categories_icon);
            }

            $paths = $request->file('categories_icon')->store('uploads', 'public');
            $category->categories_icon = $paths;
        }

        if ($request->hasFile('categories_featureimage') && $request->file('categories_featureimage')->isValid()) {
            if ($category->categories_featureimage != null || $category->categories_featureimage != '') {
                Storage::disk('public')->delete($category->categories_featureimage);
            }

            $paths = $request->file('categories_featureimage')->store('uploads', 'public');
            $category->categories_featureimage = $paths;
        }

        $category->save();

        return $this->sendResponse($category, 'Update Data Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->sendResponse([], 'Deleted Data Successfully');
    }
}
