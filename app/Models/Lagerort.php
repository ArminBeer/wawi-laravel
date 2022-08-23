<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\LoggingService;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lagerort extends Model
{
    use HasFactory, SoftDeletes;

    // Table Name
    protected $table = 'lagerorte';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'picture',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function($lagerort){
            $log = new LoggingService;
            $log->saveLog($lagerort, 'created');
        });

        static::updated(function($lagerort){
            $log = new LoggingService;
            $log->saveLog($lagerort, 'updated');
        });

        static::deleting(function($lagerort)
        {
            $lagerort->deleted_by = auth()->user()->id;
            $lagerort->save();
            $log = new LoggingService;
            $log->saveLog($lagerort, 'delete');
        });
    }

    // Beziehungen
    public function zutaten() {
        return $this->hasMany('App\Models\Zutat', 'lagerort');
    }

    public function inventuren() {
        return $this->hasMany('App\Models\Inventur', 'lagerort');
    }
}
