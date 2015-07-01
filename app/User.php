<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Auth;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password', 'confirmed'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    public function planets(){
        return $this->hasMany('\App\Planet');
    }

    public function stars(){
        return $this->hasMany('\App\Star');
    }

    public function points(){
        return $this->hasOne('\App\Point');
    }

    public function roles(){
        return $this->belongsToMany('App\Role');
    }

    public function findings(){
        return $this->hasMany('\App\Finding');
    }
    public function inModeration(){
        return $this->hasMany('\App\Moderation');
    }

    public function mayEnterCabinet(){
        $enter=\Auth::user()->roles()->where('id', 1)->first();
        if($enter) return true;
        else return false;
    }

    public function isAdmin(){
        $enter=\Auth::user()->roles()->where('id', 2)->first();
        if($enter) return true;
        else return false;
    }

    public function isModerator(){
        $enter=\Auth::user()->roles()->where('id', 3)->first();
        if($enter) return true;
        else return false;
    }

    public function hasInbox(){
        return $this->hasMany('\App\Letter', 'reciever');
    }
    public function hasSent(){
        return $this->hasMany('\App\Letter', 'sender');
    }
}
