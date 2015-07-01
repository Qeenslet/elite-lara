<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Moderation extends Model {

    protected $fillable = ['type', 'user_id', 'data', 'address'];

    public function user(){
        return $this->belongsTo('\App\User');
    }

}
