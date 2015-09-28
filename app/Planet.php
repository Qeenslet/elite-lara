<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Planet extends Model {

    protected $fillable = ['star_id', 'planet', 'mark', 'distance', 'user_id'];

    public function star()
    {
        return $this->belongsTo('App\Star');
    }

    public function user() {
        return $this->belongsTo('\App\User');
    }

    public function planetData()
    {
        return $this->hasOne('\App\Plandata');
    }

    public function scopeTwentyFour($query){
        $today=\Carbon\Carbon::now()->toDateTimeString();
        $yesterday=\Carbon\Carbon::now()->subDay()->toDateTimeString();
        return $query->whereBetween('created_at', [$yesterday, $today]);
    }

}