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

}
