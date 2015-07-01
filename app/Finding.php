<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Finding extends Model {

    protected $fillable = ['address_id'];
    public function user()
    {
        return $this->belongsToMany('\App\User');
    }

    public function address()
    {
        return $this->belongsTo('\App\Address');
    }

}
