<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\LoggingService;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventur extends Model
{
    use HasFactory, SoftDeletes;

    // Table Name
    protected $table = 'inventuren';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'lagerort',
        'user',
        'completed',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function($inventur){
            $log = new LoggingService;
            $log->saveLog($inventur, 'created');
        });

        static::updated(function($inventur){
            $log = new LoggingService;
            $log->saveLog($inventur, 'updated');
        });

        static::deleting(function($inventur)
        {
            $inventur->deleted_by = auth()->user()->id;
            $inventur->save();

            $log = new LoggingService;
            $log->saveLog($inventur, 'delete');

            $inventur->inventurActivities()->delete();

        });
    }

    // Beziehungen
    public function user() {
        return $this->belongsTo('App\Models\User', 'user');
    }
    public function lagerort() {
        return $this->belongsTo('App\Models\Lagerort', 'lagerort');
    }
    public function inventurActivities() {
        return $this->hasMany('App\Models\Inventur_Activity', 'inventur');
    }

}
