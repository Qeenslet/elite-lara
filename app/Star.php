<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Star extends Model {

    protected $fillable = ['star', 'size', 'class', 'address_id', 'user_id', 'stardata_id', 'code'];

    public function address()
    {
        return $this->belongsTo('App\Address');
    }

    public function planets()
    {
        return $this->hasMany('App\Planet');
    }

    public function user() {
        return $this->belongsTo('\App\User');
    }

    public function centers()
    {
        return $this->belongsToMany('App\Baricenter');
    }

    public function starData()
    {
        return $this->hasOne('App\Stardata');
    }

    public function scopeTwentyFour($query){
        $today=\Carbon\Carbon::now()->toDateTimeString();
        $yesterday=\Carbon\Carbon::now()->subDay()->toDateTimeString();
        return $query->whereBetween('created_at', [$yesterday, $today]);
    }


}