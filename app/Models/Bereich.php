<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bereich extends Model
{
    use HasFactory, SoftDeletes;

    // Table Name
    protected $table = 'bereiche';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'name',
    ];

    // Beziehungen
    public function kategorien() {
        return $this->belongsToMany('App\Models\Kategorie', 'kategorien_zu_bereiche', 'bereich', 'kategorie');
    }
}
