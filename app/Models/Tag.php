<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\LoggingService;


class Tag extends Model
{
    use HasFactory, SoftDeletes;

    // Table Name
    protected $table = 'tags';

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

        static::created(function($tag){
            $log = new LoggingService;
            $log->saveLog($tag, 'created');
        });

        static::deleting(function($tag)
        {
            $tag->deleted_by = auth()->user()->id;
            $tag->save();

            $log = new LoggingService;
            $log->saveLog($tag, 'delete');

        });
    }

    // Beziehungen
    public function zutaten() {
        return $this->morphedByMany('App\Models\Zutat', 'verknuepfung', 'tags_zuordnungen', 'tag', 'verknuepfung_id');
    }
}
