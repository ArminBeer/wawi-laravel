<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\LoggingService;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    use HasFactory, SoftDeletes;

    // Table Name
    protected $table = 'logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'verknuepfung_id',
        'verknuepfung_type',
        'user',
        'changes',
    ];

    // Beziehungen
    public function user() {
        return $this->belongsTo('App\Models\User', 'user');
    }

    public function model($model) {
        return $this->belongsTo($model, 'verknuepfung_id');
    }
}
