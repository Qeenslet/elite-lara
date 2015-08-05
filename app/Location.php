<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model {

    protected $fillable = ['ip', 'content'];

    public function scopeTwentyFour($query){
        $today=\Carbon\Carbon::now()->toDateTimeString();
        $yesterday=\Carbon\Carbon::now()->subDay()->toDateTimeString();
        return $query->whereBetween('created_at', [$yesterday, $today]);
    }

}
