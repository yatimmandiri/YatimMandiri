<?php

namespace App\Http\Resources\Resource;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DonationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $categories = Category::where('id', '=', $this->campaigns['categories_id'])->get();

        return [
            'id' => $this->id,
            'donation_notransaksi' => $this->donation_notransaksi,
            'donation_quantity' => $this->donation_quantity,
            'donation_nominaldonasi' => $this->donation_nominaldonasi,
            'donation_uniknominal' => $this->donation_uniknominal,
            'donation_keterangan' => $this->donation_keterangan,
            'donation_billcode' => $this->donation_billcode,
            'donation_vanumber' => $this->donation_vanumber,
            'donation_qrcode' => $this->donation_qrcode,
            'donation_deeplinks' => $this->donation_deeplinks,
            'donation_responsedonasi' => $this->donation_responsedonasi,
            'donation_shohibul' => $this->donation_shohibul,
            'donation_status' => $this->donation_status,
            'donation_hambaallah' => $this->donation_hambaallah,
            'donation_totaldonasi' => $this->donation_nominaldonasi * $this->donation_quantity + $this->donation_uniknominal,
            'user_id' => $this->user_id,
            'rekening_id' => $this->rekening_id,
            'campaign_id' => $this->campaign_id,
            'relationship' => [
                'rekenings' => $this->rekenings,
                'campaigns' => $this->campaigns,
                'categories' => $categories,
                'users' => $this->users,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
