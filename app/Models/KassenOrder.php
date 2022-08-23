<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KassenOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'business_period_id',
    ];

    function businessPeriod() {
        return $this->belongsTo(BusinessPeriod::class);
    }

    function kassenOrderItems() {
        return $this->hasMany(KassenOrderItem::class);
    }
}
