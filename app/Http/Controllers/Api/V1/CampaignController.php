<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Collection\CampaignCollection;
use App\Http\Resources\Resource\CampaignResource;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Campaign::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->orWhere('campaign_name', 'LIKE', '%' . $request->search . '%');
                    $q->orWhere('campaign_slug', 'LIKE', '%' . $request->search . '%');
                });
            })
            ->when($request->filterByCategoriesId, function ($query) use ($request) {
                $query->whereHas('categories', function ($query) use ($request) {
                    $query->whereIn('id', explode(',', $request->filterByCategoriesId));
                });
            })
            ->when($request->filterByCategories, function ($query) use ($request) {
                $query->whereHas('categories', function ($query) use ($request) {
                    $query->whereIn('categories_name', explode(',', $request->filterByCategories));
                });
            })
            ->when($request->categories_id, function ($query) use ($request) {
                $query->where('categories_id', '=', $request->categories_id);
            })
            ->when($request->recomendation, function ($query) use ($request) {
                $query->where('campaign_recomendation', '=', $request->recomendation);
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('campaign_status', '=', $request->status);
            })
            ->when($request->populer, function ($query) use ($request) {
                $query->where('campaign_populer', '=', $request->populer);
            })
            ->orderBy('id', 'desc');

        if ($request->per_page) {
            $campaigns = $query->paginate($request->per_page);
            $campaignsResource = new CampaignCollection($campaigns);
        } else {
            $campaigns = $query->get();
            $campaignsResource = CampaignResource::collection($campaigns);
        }

        return $this->sendResponse($campaignsResource, 'Get Data Successfully');
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
    public function show(Campaign $campaign)
    {
        $campaignsResource = CampaignResource::make($campaign);
        return $this->sendResponse($campaignsResource, 'Get Data Successfully');
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
        Campaign::withTrashed()->find($id)->restore();
        return $this->sendResponse([], 'Restore Data Successfully');
    }

    public function status(Campaign $campaign)
    {
        $campaigns = Campaign::find($campaign->id);

        if ($campaign->campaign_status == 'Y') {
            $campaigns->campaign_status = 'N';
        } else {
            $campaigns->campaign_status = 'Y';
        }

        $campaigns->save();
        $campaignsResource = CampaignResource::make($campaign);

        return $this->sendResponse($campaignsResource, 'Update Status Successfully');
    }

    public function populer(Campaign $campaign)
    {
        $campaigns = Campaign::find($campaign->id);

        if ($campaign->campaign_populer == 'Y') {
            $campaigns->campaign_populer = 'N';
        } else {
            $campaigns->campaign_populer = 'Y';
        }

        $campaigns->save();
        $campaignsResource = CampaignResource::make($campaign);

        return $this->sendResponse($campaignsResource, 'Update Status Successfully');
    }

    public function recomendation(Campaign $campaign)
    {
        $campaigns = Campaign::find($campaign->id);

        if ($campaign->campaign_recomendation == 'Y') {
            $campaigns->campaign_recomendation = 'N';
        } else {
            $campaigns->campaign_recomendation = 'Y';
        }

        $campaigns->save();
        $campaignsResource = CampaignResource::make($campaign);

        return $this->sendResponse($campaignsResource, 'Update Status Successfully');
    }
}
