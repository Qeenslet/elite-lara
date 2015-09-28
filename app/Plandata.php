<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Plandata extends Model{

    protected $table = 'plandatas';
    protected $hidden = ['plandata_id', 'id', 'created_at', 'updated_at', 'planet_id', 'bariplanet_id'];

    protected $fillable = ['temperature',
        'mass',
        'radius',
        'temperature',
        'pressure',
        'volcanism',
        'atm_type',
        'price',
        'planet_id',
        'bariplanet_id'];

    public function planet()
    {
        return $this->belongsTo('App\Planet');
    }

    public function bariplanet()
    {
        return $this->belongsTo('App\Bariplanet');
    }

    public function orbit()
    {
        return$this->hasOne('App\Orbit');
    }

    public function composition()
    {
        return$this->hasOne('App\Composition');
    }

    public function atmosphere()
    {
        return$this->hasOne('App\Atmosphere');
    }
}