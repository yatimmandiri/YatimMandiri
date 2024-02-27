<?php

namespace App\Http\Controllers\Core;

use App\DataTables\PermissionDataTable;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Http\Resources\Resource\PermissionResource;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PermissionDataTable $datatables)
    {
        $data['pageTitle'] = 'Permissions List';
        return $datatables->render('core.permissions.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        $permission = Permission::create($request->all())->syncRoles($request->roles);
        $permissionResource = PermissionResource::make($permission);

        return $this->sendResponse($permissionResource, 'Insert Data Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        $permissionResource = PermissionResource::make($permission);
        return $this->sendResponse($permissionResource, 'Get Data Successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->name = $request->name;
        $permission->syncRoles($request->roles);
        $permission->save();

        $permissionResource = PermissionResource::make($permission);

        return $this->sendResponse($permissionResource, 'Update Data Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return $this->sendResponse([], 'Delete Data Successfully');
    }
}
