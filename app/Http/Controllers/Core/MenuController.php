<?php

namespace App\Http\Controllers\Core;

use App\DataTables\MenuDataTable;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Http\Resources\Resource\MenuResource;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MenuDataTable $datatables)
    {
        $data = [
            'pageTitle' => 'Menus List',
        ];

        return $datatables->render('core.menus.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuRequest $request)
    {
        $latest = Menu::latest()->first();

        $menus = Menu::create(array_merge([
            'menu_name' => $request->menu_name,
            'menu_link' => $request->menu_link,
            'menu_icon' => $request->menu_icon,
            'menu_parent' => $request->menu_parent,
        ], ['menu_order' => $latest->menu_order + 1]));
        $menuResource = MenuResource::make($menus)->roles()->sync($request->roles);

        return $this->sendResponse($menuResource, 'Insert Data Successfully');
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
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $menu->menu_name = $request->menu_name;
        $menu->menu_link = $request->menu_link;
        $menu->menu_icon = $request->menu_icon;
        $menu->menu_parent = $request->menu_parent;
        $menu->roles()->sync($request->roles);
        $menu->save();

        $menusResource = MenuResource::make($menu);

        return $this->sendResponse($menusResource, 'Update Data Successfully');
    }

    public function menuOrder(Request $request, Menu $menu)
    {
        $menu->menu_order = $request->menu_order;
        $menu->save();

        $menusResource = MenuResource::make($menu);

        return $this->sendResponse($menusResource, 'Update Data Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return $this->sendResponse([], 'Deleted Data Successfully');
    }
}
