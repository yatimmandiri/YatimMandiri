<?php

namespace App\Http\Controllers\Transactions;

use App\DataTables\DonationDataTable;
use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Http\Requests\StoreDonationRequest;
use App\Http\Requests\UpdateDonationRequest;
use App\Http\Resources\Resource\DonationResource;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DonationDataTable $datatables)
    {
        $data['pageTitle'] = 'Donation List';
        return $datatables->render('transaction.donations.index', $data);
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
    public function store(StoreDonationRequest $request)
    {
        $donationsResource = DonationResource::make($request->all());

        return $this->sendResponse($donationsResource, 'Insert Data Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Donation $donation)
    {
        $donationsResource = DonationResource::make($donation);
        return $this->sendResponse($donationsResource, 'Get Data Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donation $donation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDonationRequest $request, Donation $donation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donation $donation)
    {
        //
    }
}
