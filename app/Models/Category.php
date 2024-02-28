<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'categories_name',
        'categories_title',
        'categories_slug',
        'categories_excerpt',
        'categories_description',
        'categories_icon',
        'categories_featureimage',
        'categories_populer',
        'categories_status',
    ];

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'categories_id');
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'categories_id');
    }
}
