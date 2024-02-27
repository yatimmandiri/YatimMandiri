<?php

namespace App\Http\Controllers\Core;

use App\DataTables\RoleDataTable;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\Resource\RoleResource;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RoleDataTable $datatables)
    {
        $data['pageTitle'] = 'Role List';
        return $datatables->render('core.roles.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->all())->syncPermissions($request->permissions);
        $roleResource = RoleResource::make($role)->menus()->sync($request->menus);

        return $this->sendResponse($roleResource, 'Insert Data Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $roleResource = RoleResource::make($role);
        return $this->sendResponse($roleResource, 'Get Data Successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->name = $request->name;
        $role->syncPermissions($request->permissions);
        $role->menus()->sync($request->menus);
        $role->save();

        $roleResource = RoleResource::make($role);

        return $this->sendResponse($roleResource, 'Update Data Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return $this->sendResponse([], 'Delete Data Successfully');
    }
}
