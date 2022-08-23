<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bon extends Model
{
    use HasFactory, SoftDeletes;

    // Table Name
    protected $table = 'bons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rezept',
        'menge',
        'processed',
    ];

    // Beziehungen
    public function rezept() {
        return $this->belongsTo('App\Models\Rezept', 'rezept');
    }
}
