<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\LoggingService;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventur_Activity extends Model
{
    use HasFactory, SoftDeletes;

    // Table Name
    protected $table = 'inventur_activities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'inventur',
        'zutat',
        'old_value',
        'new_value',
    ];

    // Beziehungen
    public function inventur() {
        return $this->belongsTo('App\Models\Inventur', 'inventur');
    }

    public function zutat() {
        return $this->belongsTo('App\Models\Zutat', 'zutat');
    }
}
