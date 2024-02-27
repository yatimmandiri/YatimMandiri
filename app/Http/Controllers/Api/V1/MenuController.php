<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Collection\MenuCollection;
use App\Http\Resources\Resource\MenuResource;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Menu::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('menu_name', 'LIKE', '%' . $request->search . '%');
                $query->orWhere('menu_link', 'LIKE', '%' . $request->search . '%');
            });

        if ($request->per_page) {
            $menus = $query->paginate($request->per_page);
            $menusResource = new MenuCollection($menus);
        } else {
            $menus = $query->get();
            $menusResource = MenuResource::collection($menus);
        }

        return $this->sendResponse($menusResource, 'Get Data Successfully');
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
    public function show(Menu $menu)
    {
        $menusResource = MenuResource::make($menu);
        return $this->sendResponse($menusResource, 'Get Data Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        //
    }
}
