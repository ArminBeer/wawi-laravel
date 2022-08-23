<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\LoggingService;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lieferant extends Model
{
    use HasFactory, SoftDeletes;

    // Table Name
    protected $table = 'lieferanten';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'ansprechpartner',
        'telefon',
        'plz',
        'strasse',
        'ort',
        'land',
    ];


    protected static function boot()
    {
        parent::boot();

        static::created(function($lieferant){
            $log = new LoggingService;
            $log->saveLog($lieferant, 'created');
        });

        static::updated(function($lieferant){
            $log = new LoggingService;
            $log->saveLog($lieferant, 'updated');
        });

        static::deleting(function($lieferant)
        {
            $lieferant->deleted_by = auth()->user()->id;
            $lieferant->save();

            $log = new LoggingService;
            $log->saveLog($lieferant, 'delete');

            foreach($lieferant->zutaten()->get() as $zutat){
                $zutat->lieferant = 0;
                $zutat->save();
            }

            foreach($lieferant->bestellungen()->get() as $bestellung)
                $bestellung->delete();

        });


    }

     // Beziehungen
    public function zutaten() {
        return $this->hasMany('App\Models\Zutat', 'lieferant');
    }

    public function bestellungen() {
        return $this->hasMany('App\Models\Bestellung', 'lieferant');
    }
}
