<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 28.08.2015
 * Time: 9:01
 */

namespace App\Myclasses\Insides;


class Converter {

    protected $inside;

    protected $starName;
    protected $planetName;
    protected $sizeName;



    public function __construct($addr_id)
    {
        $inside = \App\Inside::where('address_id', $addr_id)->first();
        $this->inside = unserialize($inside->data);

        $this->starName = \App\Myclasses\Arrays::allStarsArray();
        $this->planetName = \App\Myclasses\Arrays::planetsForCabinet();
        $this->sizeName = \App\Myclasses\Arrays::sizeTypeArray();

    }

    /**
     * @return mixed
     * to draw table with all objects in the system
     */
    public function getAllCenters()
    {
        return $this->inside->getCenters();
    }

    /**
     * @param centerInside $center
     * to draw either stars or baricenter for planets in the table
     */

    public function getOneCenter(centerInside $center)
    {
        $centerData=$center->giveSelfData();
        $result=[];

        if($center instanceof centerMulti){
            $result[] = $this->makeMulti($centerData);
        }
        else {
            foreach ($centerData as $one) {
                $result[] = $this->makeStar($one);
            }
        }
        return $result;
    }

    public function getCenterPlanets(centerInside $center)
    {
        $planets=$center->givePlanetsData();
        $result=[];
        if ($planets) {
            foreach ($planets as $planet) {
                $name = $this->makePlanetName($planet);
                $image = $this->makePlanetImage($planet);
                $type = $planet->type;
                $result[$planet->id] = ['name' => $name,
                    'image' => $image,
                    'type' => $type];
            }
        }
        return $result;
    }

    protected function makePlanetName(planetInfo $planet)
    {
        return $this->planetName[$planet->planet]." - ".$planet->distance." ".$planet->mark;
    }

    protected function makePlanetImage(planetInfo $planet)
    {
        return $this->planetName[$planet->planet].".png";
    }

    /**
     * @param $data
     * @return array
     */

    protected function makeStar(starInfo $star)
    {
        $starData=[];
        $starData['name']=$this->makeStarName($star);
        $starData['image']=$this->makeStarImage($star);
        $starData['id']=$star->id;
        $starData['type']='star';

        return $starData;
    }

    /**
     * @param $data
     * @return array
     */

    protected function makeMulti(array $data)
    {
        switch(\App::getLocale())
        {
            case 'ru':
                $centerData['name']='Барицентр: ';
                break;
            default:
                $centerData['name']='Barycenter: ';
        }
        foreach($data as $key=>$oneStar)
        {
            if($key=='self') continue;
            $centerData['name'].=$this->makeStarName($oneStar)."  ";
        }
        $centerData['image']='cross.png';
        $centerData['id']=$data['self'];
        $centerData['type']='multi';

        return $centerData;
    }

    protected function makeStarName(starInfo $star)
    {
        if($star->star == 15 || $star->star==16) {
            return $this->starName[$star->star];
        }
        else {
            return $this->starName[$star->star].$star->class." ".$this->sizeName[$star->size];
        }
    }

    protected function makeStarImage(starInfo $star)
    {
        return $this->starName[$star->star].'.png';
    }

    public function getAddrId()
    {
        return $this->inside->getAddressId();
    }

    public function getSystemName()
    {
        return $this->inside->getName();
    }

    public function getCenterId(centerInside $center)
    {
        $array=$center->giveSelfData();
        if (isset ($array['self'])) return $array['self'];
        else {
            $star=reset($array);
            return $star->id;
        }
    }

    public function getType(centerInside $center)
    {
        $array=$this->getOneCenter($center);
        $result=reset($array);
        return $result['type'];
    }

}