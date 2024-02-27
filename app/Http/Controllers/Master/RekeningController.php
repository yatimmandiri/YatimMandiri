<?php

namespace App\Http\Controllers\Master;

use App\DataTables\RekeningDataTable;
use App\Http\Controllers\Controller;
use App\Models\Rekening;
use App\Http\Requests\StoreRekeningRequest;
use App\Http\Requests\UpdateRekeningRequest;
use App\Http\Resources\Resource\RekeningResource;
use Illuminate\Support\Facades\Storage;

class RekeningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RekeningDataTable $datatable)
    {
        $data['pageTitle'] = 'Rekening List';
        return $datatable->render('master.rekenings.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRekeningRequest $request)
    {
        if ($request->hasFile('rekening_icon') && $request->file('rekening_icon')->isValid()) {
            $rekening_icon = $request->file('rekening_icon')->store('uploads', 'public');
        } else {
            $rekening_icon = null;
        }

        $defaultValue = [
            'rekening_icon' => $rekening_icon,
        ];

        $rekening = Rekening::create(array_merge($request->all(), $defaultValue));

        $rekeningResource = RekeningResource::make($rekening);

        return $this->sendResponse($rekeningResource, 'Insert Data Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rekening $rekening)
    {
        $rekeningResource = RekeningResource::make($rekening);
        return $this->sendResponse($rekeningResource, 'Get Data Successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRekeningRequest $request, Rekening $rekening)
    {
        $rekening->rekening_name = $request->rekening_name;
        $rekening->rekening_bank = $request->rekening_bank;
        $rekening->rekening_number = $request->rekening_number;
        $rekening->rekening_provider = $request->rekening_provider;
        $rekening->rekening_group = $request->rekening_group;
        $rekening->rekening_token = $request->rekening_token;

        if ($request->hasFile('rekening_icon') && $request->file('rekening_icon')->isValid()) {
            if ($rekening->rekening_icon != null || $rekening->rekening_icon != '') {
                Storage::disk('public')->delete($rekening->rekening_icon);
            }

            $paths = $request->file('rekening_icon')->store('uploads', 'public');
            $rekening->rekening_icon = $paths;
        }

        $rekening->save();

        $rekeningResource = RekeningResource::make($rekening);

        return $this->sendResponse($rekeningResource, 'Update Data Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rekening $rekening)
    {
        $rekening->delete();
        return $this->sendResponse([], 'Deleted Data Successfully');
    }
}
