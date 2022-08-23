<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\LoggingService;

class Kategorie extends Model
{
    use HasFactory, SoftDeletes;

    // Table Name
    protected $table = 'kategorien';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'name',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function($kategorie){
            $log = new LoggingService;
            $log->saveLog($kategorie, 'created');
        });

        static::deleting(function($kategorie)
        {
            $kategorie->deleted_by = auth()->user()->id;
            $kategorie->save();

            $log = new LoggingService;
            $log->saveLog($kategorie, 'delete');

        });
    }

    // Beziehungen
    public function bereiche() {
        return $this->belongsToMany('App\Models\Bereich', 'kategorien_zu_bereiche', 'kategorie', 'bereich');
    }

    public function zutaten() {
        return $this->morphedByMany('App\Models\Zutat', 'verknuepfung', 'kategorien_zuordnungen', 'kategorie', 'verknuepfung_id');
    }
}
