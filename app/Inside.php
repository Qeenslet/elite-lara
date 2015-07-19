<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Inside extends Model {

    protected $fillable = ['data', 'address_id'];

     public function address(){
         return $this->belongsTo('\App\Address');
     }

}
