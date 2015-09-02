<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 28.08.2015
 * Time: 8:20
 */

namespace App\Myclasses\Insides;


class centerMulti extends centerInside{

    private $stars;
    private $planets;

    public function __construct($id)
    {
        //construct new StarInfo dew to the database id

        $bari=\App\Baricenter::find($id);

        foreach($bari->stars()->get() as $star)
        {
            $this->stars[$star->id]=new starInfo($star);
        }
        $this->stars['self']=$bari->id;

        //construct planets array with new PlanetInfo objects
        foreach($bari->planets()->get() as $planet)
        {
          $this->planets[$planet->id]=new planetInfo($planet);
        }
    }
    function giveSelfData()
    {
        return $this->stars;
    }

    function givePlanetsData()
    {
        return $this->planets;
    }
}