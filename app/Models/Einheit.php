<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Einheit extends Model
{
    use HasFactory, SoftDeletes;

    // Table Name
    protected $table = 'einheiten';

    /**
     * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'name',
        'kuerzel',
        'grundeinheit',
        'conversion_needed',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($einheit)
        {
            $einheit->deleted_by = auth()->user()->id;
            $einheit->save();

            $einheit->inverseUmrechnungen()->delete();
            $einheit->straightUmrechnungen()->delete();
        });
    }

    // Beziehungen
    public function zutaten() {
        return $this->hasMany('App\Models\Zutat', 'einheit');
    }

    public function inverseUmrechnungen() {
        return $this->hasMany('App\Models\Umrechnung', 'soll_einheit');
    }

    public function straightUmrechnungen() {
        return $this->hasMany('App\Models\Umrechnung', 'ist_einheit');
    }

    public function umrechnungen() {
        return $this->hasMany('App\Models\Umrechnung', 'ist_einheit')->orWhere('soll_einheit','=',$this->id);
    }

    public function getAttachedGrundeinheiten(){

        $umrechnungen = $this->umrechnungen()->get();
        $attachedGrundeinheiten = collect(new Einheit);
        foreach($umrechnungen as $umrechnung){
            if ($umrechnung->ist_einheit()->first()->grundeinheit)
                $attachedGrundeinheiten[] = $umrechnung->ist_einheit()->first();

            if ($umrechnung->soll_einheit()->first()->grundeinheit)
                $attachedGrundeinheiten[] = $umrechnung->soll_einheit()->first();
        }

        if ($attachedGrundeinheiten->first())
            $attachedGrundeinheiten = $attachedGrundeinheiten->unique();
        else
            $attachedGrundeinheiten = $this;

        return $attachedGrundeinheiten;
    }

}
