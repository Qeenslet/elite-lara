<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 29.08.2015
 * Time: 11:34
 */

namespace App\Myclasses\Insides;


class ConverterForUser extends Converter{

    protected $user;

    public function __construct($addr_id, $user_id)
    {
        parent::__construct($addr_id);
        $this->user=$user_id;
    }

    protected function isDiscByUser(objectInfo $object)
    {
        if ($object->user == $this->user) return true;
        return false;
    }

    public function getCenterPlanets(centerInside $center)
    {
        $planets=$center->givePlanetsData();
        $result=[];
        if ($planets) {
            foreach ($planets as $planet) {
                if (!$this->isDiscByUser($planet)) continue;
                $name = $this->makePlanetName($planet);
                $image = $this->makePlanetImage($planet);
                $type = $planet->type;

                if (isset ($planet->extra))
                {
                    $extraD = $this->makePlanetExtras($planet->extra);
                    $name = $name.' / '.$this->addGravity($planet->extra);
                    $result[$planet->id] = ['name' => $name,
                        'image' => $image,
                        'type' => $type,
                        'extra' => $extraD];
                }
                else
                {
                    $result[$planet->id] = ['name' => $name,
                        'image' => $image,
                        'type' => $type];
                }
            }
        }
        return $result;
    }

    protected function makeStarName(starInfo $star)
    {
        if (!$this->isDiscByUser($star)) $mark=' Добавлена не вами';
        else $mark='';
        if($star->star == 15 || $star->star==16) {
            return $this->starName[$star->star].$mark;
        }
        else {
            return $this->starName[$star->star].$star->class." ".$this->sizeName[$star->size].$mark;
        }
    }

    protected function makeStarImage(starInfo $star)
    {
        if (!$this->isDiscByUser($star)) return 'default.png';
        else  return $this->starName[$star->star].'.png';
    }


}