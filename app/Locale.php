<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Locale extends Model {

    protected $fillable = ['lang'];

    public function users(){
        return $this->belongsToMany('App\User');
    }

}
