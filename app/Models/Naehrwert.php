<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Naehrwert extends Model
{
    use HasFactory, SoftDeletes;

    // Table Name
    protected $table = 'naehrwerte';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'einheit',
    ];

    // Beziehungen
    public function rezept() {
        return $this->belongsToMany('App\Models\Rezept', 'rezepte_zu_naehrwerte', 'naehrwert', 'rezept');
    }
}
