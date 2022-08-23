<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\LoggingService;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bestellung_Activity extends Model
{
    use HasFactory, SoftDeletes;

    // Table Name
    protected $table = 'bestellung_activities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bestellung',
        'status',
        'user',
        'changes',
    ];

    // Beziehungen
    public function bestellung() {
        return $this->belongsTo('App\Models\Bestellung', 'bestellung');
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user');
    }
}
