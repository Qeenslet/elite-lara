<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model {

    protected $fillable = ['ip', 'content'];

    public function scopeTwentyFour($query)
    {
        $today=\Carbon\Carbon::now()->toDateTimeString();
        $yesterday=\Carbon\Carbon::now()->subDay()->toDateTimeString();
        return $query->whereBetween('created_at', [$yesterday, $today]);
    }

    public function scopeWeek($query)
    {
        $today=\Carbon\Carbon::now()->toDateTimeString();
        $weekBack=\Carbon\Carbon::now()->subWeek()->toDateTimeString();
        return $query->whereBetween('created_at', [$weekBack, $today]);
    }

}
