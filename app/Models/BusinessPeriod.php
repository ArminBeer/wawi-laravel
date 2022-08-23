<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'businessDay',
        'startPeriodTimestamp',
        'finishPeriodTimestamp',
        'business_id',
    ];

    function kassenOrders() {
        return $this->hasMany(KassenOrder::class);
    }

    function kassenOrderItems() {
        return $this->hasManyThrough(KassenOrderItem::class, KassenOrder::class);
    }
}
