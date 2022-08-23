<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Global_Inventurflag extends Model
{
    use HasFactory;

    // Table Name
    protected $table = 'inventur_flag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'active',
        'user',
    ];

    // Beziehungen
    public function user() {
        return $this->belongsTo('App\Models\User', 'user');
    }
}
