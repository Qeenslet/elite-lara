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

}