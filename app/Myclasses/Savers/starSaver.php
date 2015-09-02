<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 30.08.2015
 * Time: 15:28
 */

namespace App\Myclasses\Savers;


class starSaver extends Saver{

    public function __construct(\App\Myclasses\Checks\checkStar $checker)
    {
        parent::__construct($checker);
        $this->address=$checker->getAddress();
        $this->addrId=$this->address->id;
        if(isset($this->data['user'])) $this->user=$this->data['user'];
        else {
            $this->user=\Auth::user()->id;
        }
        try {
            $this->saveStar();

            $this->finalize();
        }
        catch (\PDOException $e){
            $this->rollback();
        }

    }

    protected function saveStar(){
        $array = ['star' => $this->data['star'],
            'size' => $this->data['size'],
            'class' => $this->data['class'],
            'address_id' => $this->data['address'],
            'user_id' => $this->user,
            'code'=>$this->data['code'],
            'stardata_id' => 0];
        $star = \App\Star::create($array);
        $this->starId = $star->id;

    }

    protected function saveStats()
    {
        parent::saveStats();
        $this->statistics->latest_stars+=1;
        $this->statistics->save();
    }

    protected function savePoints()
    {
        parent::savePoints();
        $starV = \App\StarsValue::where('star', $this->data['star'])->first();
        $this->userInstance->points()->increment('stars', 1);
        $value = $starV->value * $starV->modifier;
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