<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Statcache extends Model {

    protected $fillable = ['addresses',
        'planets',
        'regions',
        'tf',
        'latest_stars',
        'latest_planets',
        'latest_regions',
        'latest_addresses'];

    public function scopeWeek($query)
    {
        $today=\Carbon\Carbon::now()->toDateTimeString();
        $yesterday=\Carbon\Carbon::now()->subWeek()->toDateTimeString();
        return $query->whereBetween('created_at', [$yesterday, $today]);
    }

}
