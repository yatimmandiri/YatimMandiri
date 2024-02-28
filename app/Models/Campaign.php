<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'campaign_name',
        'campaign_title',
        'campaign_slug',
        'campaign_excerpt',
        'campaign_description',
        'campaign_featureimage',
        'campaign_template',
        'campaign_nominal',
        'campaign_nominal_min',
        'campaign_status',
        'campaign_populer',
        'campaign_recomendation',
        'categories_id',
        'paket_id',
    ];

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }
}
