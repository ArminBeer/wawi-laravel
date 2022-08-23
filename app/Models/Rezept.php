<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\LoggingService;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rezept extends Model
{
    use HasFactory, SoftDeletes;

    // Table Name
    protected $table = 'rezepte';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'zubereitung',
        'picture',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function($rezept){
            $log = new LoggingService;
            $log->saveLog($rezept, 'created');
        });
        static::updated(function($rezept){
            $log = new LoggingService;
            $log->saveLog($rezept, 'updated');
        });

        static::deleting(function($rezept)
        {
            if ($rezept->zubereitung()->first())
                $rezept->zubereitung()->delete();
            // $rezept->zutaten()->detach();

            $rezept->deleted_by = auth()->user()->id;
            $rezept->save();

            $log = new LoggingService;
            $log->saveLog($rezept, 'delete');
        });
    }

    // Beziehungen
    public function zubereitung(){
        return $this->belongsTo('App\Models\Zubereitung', 'zubereitung');
    }

    public function naehrwerte() {
        return $this->belongsToMany('App\Models\Naehrwert', 'rezepte_zu_naehrwerte', 'rezept', 'naehrwert')->withPivot('menge');
    }

    public function zutaten(){
        return $this->morphToMany('App\Models\Zutat', 'verknuepfung', 'zutaten_zu_rezepte_produkte', null, 'zutat')->withPivot('menge', 'einheit', 'verlust');
    }

    public function produkte() {
        return $this->zutaten()->where('lieferant', null)->get();
    }

    public function articles() {
        return $this->hasMany('App\Models\Article', 'rezept');
    }

}
