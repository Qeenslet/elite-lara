<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 28.08.2015
 * Time: 7:23
 */

namespace App\Myclasses\Insides;


class centerStar extends centerInside{

    private $star;
    private $planets;

    public function __construct($id)
    {
       //construct new StarInfo dew to the database id
        $star=\App\Star::find($id);
        $this->star[$id]=new starInfo($star);

       //construct planets array with new PlanetInfo objects
        foreach($star->planets()->get() as $planet){
            $this->planets[$planet->id]=new planetInfo($planet);
        }
    }

    function giveSelfData()
    {
        return $this->star;
    }

    function givePlanetsData()
    {
        return $this->planets;
    }
}