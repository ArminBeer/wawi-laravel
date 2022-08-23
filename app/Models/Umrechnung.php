<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Umrechnung extends Model
{
    use HasFactory, SoftDeletes;

    // Table Name
    protected $table = 'umrechnungen';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'ist_einheit',
        'soll_einheit',
        'faktor',
    ];

     // Beziehungen
    public function zutaten() {
        return $this->hasMany('App\Models\Zutat', 'umrechnung');
    }

    public function ist_einheit() {
        return $this->belongsTo('App\Models\Einheit', 'ist_einheit');
    }

    public function soll_einheit() {
        return $this->belongsTo('App\Models\Einheit', 'soll_einheit');
    }

}
