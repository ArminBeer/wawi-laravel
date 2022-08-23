<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Services\LoggingService;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bestellung extends Model
{
    use HasFactory, SoftDeletes;

    // Table Name
    protected $table = 'bestellungen';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'user',
        'lieferant',
        'status',
        'bestellnotiz',
        'lagernotiz',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function($bestellung){
            $log = new LoggingService;
            $log->saveLog($bestellung, 'created');
        });

        static::updated(function($bestellung){
            $log = new LoggingService;
            $log->saveLog($bestellung, 'updated');
        });

        static::deleting(function($bestellung)
        {
            $bestellung->deleted_by = auth()->user()->id;
            $bestellung->save();

            $log = new LoggingService;
            $log->saveLog($bestellung, 'delete');

            // $bestellung->zutaten()->detach();
            $bestellung->bestellungActivities()->delete();
            if($bestellung->childOrParent() == 'child'){
                $parent = $bestellung->parent()->first();
                $parent->child_id = null;
                $parent->save();
            }

        });
    }

    // Beziehungen
    public function zutaten() {
        return $this->belongsToMany('App\Models\Zutat', 'bestellungen_zu_zutaten', 'bestellung', 'zutat')->withPivot('bestellmenge', 'liefermenge');
    }

    public function lieferant() {
        return $this->belongsTo('App\Models\Lieferant', 'lieferant');
    }

    public function child() {
        if ($this->child_id)
        return $this->belongsTo(self::class, 'child_id');
    }

    public function parent() {
        return $this->hasOne(self::class, 'child_id');
    }

    public function bestellungActivities() {
        return $this->hasMany('App\Models\Bestellung_Activity', 'bestellung');
    }

    public function latestActivity() {
        return $this->bestellungActivities()->orderBy('created_at', 'DESC')->orderBy('status', 'DESC')->with('user')->first();
    }

    // Check if bestellung is parent, child or has no relation
    public function childOrParent() {
        if ($this->child_id)
            return 'parent';
        elseif ($this->parent()->first())
            return 'child';
        else
            return false;
    }

    //check if bestellung has activity with status "bestellt"
    public function isOrdered(){
        if ($this->bestellungActivities()->where('status', 'bestellt')->first())
            return true;
        else
            return false;
    }

    function sendOrder()
    {
        $bestellung = $this;

        // Send email
        Mail::send('emails.order', ['bestellung' => $bestellung], function ($m) use ($bestellung) {
            $m->from('strizzi@27plus2.de', 'Warenwirtschaft Strizzi');
            $m->to($bestellung->lieferant()->first()->email, $bestellung->lieferant()->first()->name)->subject('Neue Bestellung');
        });
    }
}
