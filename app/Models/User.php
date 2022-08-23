<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Services\LoggingService;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'staff_right',
        'kitchen_right',
        'warehouse_right',
        'order_right',
        'password',
        'picture',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'staff_right' => 0,
        'kitchen_watch_right' => 0,
        'kitchen_edit_right' => 0,
        'warehouse_right' => 0,
        'order_right' => 0,
        'stocktaking_right' => 0,
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function($user){
            $log = new LoggingService;
            $log->saveLog($user, 'created');
        });

        static::deleting(function($user)
        {
            $user->deleted_by = auth()->user()->id;
            $user->save();

            $log = new LoggingService;
            $log->saveLog($user, 'delete');
        });

        static::updated(function($user){
            $log = new LoggingService;
            $log->saveLog($user, 'updated');
        });

    }


    public function hasPermission($permission) {
        if ($this->$permission)
            return true;
        else
            return false;
    }

    //Beziehungen
    public function bestellungsActivities() {
        return $this->hasMany('App\Models\Bestellung_Activity', 'user');
    }

    public function logs() {
        return $this->hasMany('App\Models\Log', 'user');
    }

    public function inventuren() {
        return $this->hasMany('App\Models\Inventur', 'user');
    }

    public function globalInventurFlag() {
        return $this->hasMany('App\Models\Global_Inventurflag', 'user');
    }

    public static function generatePassword()
    {
        // Generate random string and encrypt it.
        return bcrypt(Str::random(30));
    }

    function sendWelcomeEmail()
    {
        $user = $this;

        // Generate a new reset password token
        $token = app('auth.password.broker')->createToken($this);

        $url = config('app.url');
        $resetUrl= url(config('app.url').route('password.reset', $token, false)).'?email='.urlencode($user['email']);

        // Send email
        Mail::send('emails.welcome', ['user' => $user, 'token' => $token, 'url_db' => $url, 'url' => $resetUrl], function ($m) use ($user) {
            $m->from('strizzi@27plus2.de', 'Strizzi');
            $m->to($user['email'], $user['name'])->subject('Freischaltung zum Warenwirtschaftssystems von Strizzi');
        });
    }

}
