<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model {

    public $timestamps = false;
    protected $fillable = ['name', 'region_id'];

    public function region()
    {
        return $this->belongsTo('App\Region');
    }

    public function stars()
    {
        return $this->hasMany('App\Star');
    }

    public function discoveries(){
        return $this->hasMany('\App\Finding');
    }

    public function scopeSearch($query, $string){
        return $query->where('name', $string);
    }

    public function inside(){
        return $this->hasOne('\App\Inside');
    }

}