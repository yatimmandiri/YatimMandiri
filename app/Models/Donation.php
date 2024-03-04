<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'donation_notransaksi',
        'donation_quantity',
        'donation_nominaldonasi',
        'donation_uniknominal',
        'donation_keterangan',
        'donation_billcode',
        'donation_vanumber',
        'donation_qrcode',
        'donation_deeplinks',
        'donation_responsedonasi',
        'donation_referals',
        'donation_shohibul',
        'donation_status',
        'donation_hambaallah',
        'donation_sync',
        'donation_expired',
        'user_id',
        'campaign_id',
        'rekening_id',
    ];

    public function campaigns()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }

    public function rekenings()
    {
        return $this->belongsTo(Rekening::class, 'rekening_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
