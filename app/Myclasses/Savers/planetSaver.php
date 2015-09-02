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

    public function __construct(checkPlanet $checker)
    {
        parent::__construct($checker);
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
            'user_id' => $this->user,
            'plandata_id' => 0];
        $planet=\App\Planet::create($array);
        $this->planetId=$planet->id;

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