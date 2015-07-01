<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model {

    public $timestamps = false;
    protected $fillable = ['user_id', 'stars', 'planets', 'points'];

    public function user(){
        return $this->belongsTo('\App\User');
    }

}
