<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\LoggingService;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zubereitung extends Model
{
    use HasFactory, SoftDeletes;

    // Table Name
    protected $table = 'zubereitungen';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description_short',
        'description_long',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function($zubereitung){
            $log = new LoggingService;
            $log->saveLog($zubereitung, 'created');
        });

        static::updated(function($zubereitung){
            $log = new LoggingService;
            $log->saveLog($zubereitung, 'updated');
        });

        static::deleting(function($zubereitung)
        {
            $zubereitung->deleted_by = auth()->user()->id;
            $zubereitung->save();

            $log = new LoggingService;
            $log->saveLog($zubereitung, 'delete');
        });

    }

    // Beziehungen
    public function produkt() {
        return $this->hasOne('App\Models\Produkt', 'zubereitung');
    }

    public function rezept() {
        return $this->hasOne('App\Models\Rezept', 'zubereitung');
    }

    public function log(){
        return $this->morphToMany('App\Models\Zubereitung', 'verknuepfung', 'log', null, 'zutat')->withPivot('menge', 'einheit', 'verlust');
    }

}
