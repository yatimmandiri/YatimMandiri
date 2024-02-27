<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'faq_name',
        'faq_content',
        'faq_status',
        'categories_id',
    ];

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }
}
