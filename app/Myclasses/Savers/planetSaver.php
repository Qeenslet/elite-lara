<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 01.09.2015
 * Time: 9:30
 */

namespace App\Myclasses\Savers;


use App\Myclasses\Checks\checkPlanet;

class planetSaver extends Saver {

    protected $star;
    protected $planetId;
    protected $ignore;

    public function __construct(checkPlanet $checker, $ignore = false)
    {
        parent::__construct($checker);
        if($ignore)
            $this->ignore = 1;
        else
            $this->ignore = 0;
        $this->address=$checker->getAddress();
        $this->addrId=$this->address->id;
        if(isset($this->data['user'])) $this->user=$this->data['user'];
        else {
            $this->user=\Auth::user()->id;
        }
        $this->star=$checker->getCenterObject();
        try {
            $this->savePlanet();
            $this->finalize();
        }
        catch (\PDOException $e){
            $this->rollback();
        }
    }

    protected function savePlanet(){
        $array = ['star_id' => $this->star->id,
            'planet' => $this->data['planet'],
            'mark' => $this->data['mark'],
            'distance' => $this->data['distance'],
            'user_id' => $this->user];
        $planet=\App\Planet::create($array);
        $this->planetId=$planet->id;
        if ($this->ignore == 1)
        {
            $planet->show = 'false';
            $planet->save();
        }

    }

    protected function saveStats()
    {
        parent::saveStats();
        $this->statistics->latest_planets+=1;
        $this->statistics->planets+=1;
        if($this->data['planet']<4) $this->statistics->tf+=1;
        $this->statistics->save();
    }

    protected function savePoints()
    {
        parent::savePoints();
        $planetV = \App\PlanetsValue::where('planet', $this->data['planet'])->first();
        $this->userInstance->points()->increment('planets', 1);
        $value = $planetV->value * $planetV->modifier;
        if($value>0) {
            $this->userInstance->points()->increment('points', $value);
        }
    }

    protected function finalize()
    {
        $this->saveStats();
        $this->savePoints();
        $this->saveInsides();
        $this->commit();
    }
}