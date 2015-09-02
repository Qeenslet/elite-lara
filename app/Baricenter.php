<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Baricenter extends Model {

    protected $fillable = ['address_id'];

    public $timestamps = false;

    public function stars(){
        return $this->belongsToMany('App\Star');
    }

    public function address()
    {
        return $this->belongsTo('App\Address');
    }

    public function planets()
    {
        return $this->hasMany('App\Bariplanet');
    }

}
