<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    // Table Name
    protected $table = 'articles';


    protected $fillable = [
        'rezept',
        'sku',
        'business_id',
    ];

    public function rezept(){
        return $this->belongsTo('App\Models\Rezept', 'rezept');
    }

}
