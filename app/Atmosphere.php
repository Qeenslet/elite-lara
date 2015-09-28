<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Atmosphere extends Model{

    public $timestamps = false;
    protected $hidden = ['plandata_id', 'id'];

    protected $fillable = ['amm',
        'oxy',
        'nit',
        'arg',
        'hel',
        'wat',
        'hyd',
        'sud',
        'cad',
        'irn',
        'met',
        'neo',
        'sil',
        'plandata_id'];

    public function planetData()
    {
        return $this->belongsTo('App\Plandata');
    }
}