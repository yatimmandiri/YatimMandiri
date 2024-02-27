<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rekening extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'rekening_name',
        'rekening_number',
        'rekening_bank',
        'rekening_provider',
        'rekening_token',
        'rekening_group',
        'rekening_icon',
        'rekening_status',
        'rekening_populer',
    ];
}
