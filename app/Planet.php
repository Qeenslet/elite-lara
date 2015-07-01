<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Planet extends Model {

    protected $fillable = ['star_id', 'planet', 'mark', 'distance', 'user_id', 'plandata_id'];

    public function star()
    {
        return $this->belongsTo('App\Star');
    }

    public function user() {
        return $this->belongsTo('\App\User');
    }

}