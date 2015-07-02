<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model {

    protected $fillable = ['reciever', 'header', 'body', 'show'];

	public function isSender(){
         return $this->belongsTo('\App\User', 'sender');
    }
    public function isReciever(){
        return $this->belongsTo('\App\User', 'reciever');
    }

}
