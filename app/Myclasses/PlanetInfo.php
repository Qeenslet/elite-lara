<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12.07.2015
 * Time: 19:13
 */

namespace App\Myclasses;


class PlanetInfo {
    public $planet;
    public $distance;
    public $mark;
    public $user;

    function __construct($planet, $distance, $mark, $user)
    {
        $this->planet = $planet;
        $this->distance = $distance;
        $this->mark = $mark;
        $this->user = $user;
    }

    public static function getFromDb($id)
    {
       $data=\App\Planet::find($id);
        $newPlanet = new self($data->planet, $data->distance, $data->mark, $data->user);
        return $newPlanet;
    }
}