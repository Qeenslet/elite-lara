<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Stardata extends Model {

    protected $table = 'stardatas';

    protected $fillable = ['age', 'smass', 'srad', 'temperature', 'star_id'];
    protected $hidden = ['star_id', 'id'];

    public $timestamps = false;

    public function star()
    {
        return $this->belongsTo('App\Star');
    }




}