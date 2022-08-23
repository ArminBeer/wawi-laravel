<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Allergen extends Model
{
    use HasFactory, SoftDeletes;

    // Table Name
    protected $table = 'allergene';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'tag',
        'icon',
    ];

    // Beziehungen
    public function zutaten() {
        return $this->belongsToMany('App\Models\Zutat', 'zutaten_zu_allergene', 'allergen', 'zutat');
    }
}
