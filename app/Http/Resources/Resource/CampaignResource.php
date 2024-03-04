<?php

namespace App\Http\Resources\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $totaldonation = Donation::where('donation_status', 'Success')
        //     ->where('campaign_id', $this->id)
        //     ->sum(DB::raw('donation_quantity * donation_nominaldonasi + donation_uniknominal'));

        return [
            'id' => $this->id,
            'campaign_name' => $this->campaign_name,
            'campaign_title' => $this->campaign_title,
            'campaign_slug' => $this->campaign_slug,
            'campaign_excerpt' => $this->campaign_excerpt,
            'campaign_description' => $this->campaign_description,
            'campaign_template' => $this->campaign_template,
            'campaign_nominal' => $this->campaign_nominal,
            'campaign_nominal_min' => $this->campaign_nominal_min,
            'campaign_featureimage' => $this->campaign_featureimage,
            'campaign_status' => $this->campaign_status,
            'campaign_populer' => $this->campaign_populer,
            'campaign_recomendation' => $this->campaign_recomendation,
            'paket_id' => $this->paket_id,
            'categories_id' => $this->categories_id,
            'relationship' => [
                // 'views' => $this->vistiLogs,
                // 'total_donation' => $totaldonation,
                'categories' => $this->categories,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
