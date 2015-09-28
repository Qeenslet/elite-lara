<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Orbit extends Model{

    public $timestamps = false;
    protected $hidden = ['plandata_id', 'id'];

    protected $fillable = ['orbP',
        'mAxis',
        'ecce',
        'incl',
        'peri',
        'rotP',
        'aTilt',
        'locked',
        'plandata_id'];

    public function planetData()
    {
        return $this->belongsTo('App\Plandata');
    }
}