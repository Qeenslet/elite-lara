<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Composition extends Model{

    public $timestamps = false;
    protected $hidden = ['plandata_id', 'id'];

    protected $fillable = ['ice', 'rock', 'metal', 'plandata_id'];

    public function planetData()
    {
        return $this->belongsTo('App\Plandata');
    }
}