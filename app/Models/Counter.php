<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    use HasFactory;

    // Table Name
    protected $table = 'counters';

    protected $fillable = [
        'day',
        'type',
        'price',
    ];

}
