<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Collection\UserCollection;
use App\Http\Resources\Resource\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query()
            ->when($request->roles, function ($query) use ($request) {
                $query
                    ->with(['roles'])
                    ->whereHas('roles', function ($query) use ($request) {
                        $query->where('name', [$request->roles]);
                    });
            })
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->search . '%');
                $query->orWhere('email', 'LIKE', '%' . $request->search . '%');
            });

        if ($request->per_page) {
            $users = $query->paginate($request->per_page);
            $usersResource = new UserCollection($users);
        } else {
            $users = $query->get();
            $usersResource = UserResource::collection($users);
        }

        return $this->sendResponse($usersResource, 'Get Data Successfully');
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
    public function show(User $user)
    {
        $usersResource = UserResource::make($user);
        return $this->sendResponse($usersResource, 'Get Data Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
