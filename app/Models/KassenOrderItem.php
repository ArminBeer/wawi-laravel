<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KassenOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'kassen_order_id',
        'itemSku',
        'quantity',
        'units',
        'recordedTimestamp',
        'sequenceNumber',
        ];

    function kassenOrder() {
        return $this->belongsTo(KassenOrder::class);
    }

    function rezept() {
        return $this->hasOne(Rezept::class, 'sku', 'itemSku');
    }
}
