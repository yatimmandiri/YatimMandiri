<?php

namespace App\Http\Controllers\Master;

use App\DataTables\CampaignDataTable;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use App\Http\Resources\Resource\CampaignResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CampaignDataTable $datatable)
    {
        $data['pageTitle'] = 'Campaigns List';
        return $datatable->render('master.campaigns.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['pageTitle'] = 'Campaigns Create';
        return view('master.campaigns.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCampaignRequest $request)
    {
        if ($request->hasFile('campaign_featureimage') && $request->file('campaign_featureimage')->isValid()) {
            $campaign_featureimage = $request->file('campaign_featureimage')->store('uploads', 'public');
        } else {
            $campaign_featureimage = null;
        }

        $defaultValue = [
            'campaign_title' => Str::title($request->campaign_name),
            'campaign_slug' => Str::slug($request->campaign_name, '-'),
            'campaign_excerpt' => Str::limit(strip_tags($request->campaign_description), 100),
            'campaign_featureimage' => $campaign_featureimage,
        ];

        $campaigns = Campaign::create(array_merge($request->all(), $defaultValue));

        $campaignsResource = CampaignResource::make($campaigns);

        return $this->sendResponse($campaignsResource, 'Insert Data Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        $data['pageTitle'] = 'Campaign Show';
        $data['campaign'] = $campaign;
        return view('master.campaigns.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign)
    {
        $data['pageTitle'] = 'Campaigns Update';
        $data['campaign'] = $campaign;
        return view('master.campaigns.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCampaignRequest $request, Campaign $campaign)
    {
        $campaign->campaign_name = $request->campaign_name;
        $campaign->campaign_title = Str::title($request->campaign_name);
        $campaign->campaign_slug = Str::slug($request->campaign_name, '-');
        $campaign->campaign_description = $request->campaign_description;
        $campaign->campaign_nominal = $request->campaign_nominal;
        $campaign->campaign_nominal_min = $request->campaign_nominal_min;
        $campaign->campaign_template = $request->campaign_template;
        $campaign->categories_id = $request->categories_id;
        $campaign->paket_id = $request->paket_id;
        $campaign->campaign_excerpt = Str::words(strip_tags($request->campaign_description), 100);

        if ($request->hasFile('campaign_featureimage') && $request->file('campaign_featureimage')->isValid()) {
            if ($campaign->campaign_featureimage != null || $campaign->campaign_featureimage != '') {
                Storage::disk('public')->delete($campaign->campaign_featureimage);
            }

            $paths = $request->file('campaign_featureimage')->store('uploads', 'public');
            $campaign->campaign_featureimage = $paths;
        }

        $campaign->save();

        return $this->sendResponse($campaign, 'Update Data Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return $this->sendResponse([], 'Deleted Data Successfully');
    }
}
