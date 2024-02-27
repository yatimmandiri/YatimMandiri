<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Collection\RekeningCollection;
use App\Http\Resources\Resource\RekeningResource;
use App\Models\Rekening;
use Illuminate\Http\Request;

class RekeningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Rekening::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('rekening_name', 'LIKE', '%' . $request->search . '%');
                $query->orWhere('rekening_bank', 'LIKE', '%' . $request->search . '%');
                $query->orWhere('rekening_number', 'LIKE', '%' . $request->search . '%');
            })
            ->when($request->provider, function ($query) use ($request) {
                $query->where('rekening_provider', $request->provider);
            })
            ->when($request->group, function ($query) use ($request) {
                $query->where('rekening_group', $request->group);
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('rekening_status', $request->status);
            });

        if ($request->per_page) {
            $rekenings = $query->paginate($request->per_page);
            $rekeningsResource = new RekeningCollection($rekenings);
        } else {
            $rekenings = $query->get();
            $rekeningsResource = RekeningResource::collection($rekenings);
        }

        return $this->sendResponse($rekeningsResource, 'Get Data Successfully');
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
    public function show(Rekening $rekening)
    {
        $rekeningsResource = RekeningResource::make($rekening);
        return $this->sendResponse($rekeningsResource, 'Get Data Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function restore($id)
    {
        Rekening::withTrashed()->find($id)->restore();
        return $this->sendResponse([], 'Restore Data Successfully');
    }

    public function status(Rekening $rekening)
    {
        $rekenings = Rekening::find($rekening->id);

        if ($rekenings->rekening_status == 'Y') {
            $rekenings->rekening_status = 'N';
        } else {
            $rekenings->rekening_status = 'Y';
        }

        $rekenings->save();
        $rekeningsResource = RekeningResource::make($rekening);

        return $this->sendResponse($rekeningsResource, 'Update Status Successfully');
    }

    public function populer(Rekening $rekening)
    {
        Rekening::where('rekening_populer', '=', 'Y')->update(['rekening_populer' => 'N']);

        $rekenings = Rekening::find($rekening->id);

        $rekenings->rekening_populer = 'Y';

        $rekenings->save();
        $rekeningsResource = RekeningResource::make($rekening);

        return $this->sendResponse($rekeningsResource, 'Update Status Successfully');
    }
}
