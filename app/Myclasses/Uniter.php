<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 18.07.2015
 * Time: 12:36
 */

namespace App\Myclasses;


class Uniter {
    protected $oldId;
    protected $newId;
    protected $newAddr;
    protected $oldAddr;

    protected $result;

    protected function __construct($oldId, $newId)
    {
        $this->oldId = $oldId;
        $this->newId = $newId;
        $this->findAddresses();
    }

    public static function unite($oldId, $newId)
    {
        $union = new self($oldId, $newId);
        if($union->result==true) return true;
        else return false;
    }

    protected function findAddresses()
    {
        $this->newAddr=\App\Address::find($this->newId);
        $this->oldAddr=\App\Address::find($this->oldId);
        $this->result['addresses']='found';
        $this->checkStars();

    }

    protected function checkStars()
    {
        $connectedStars=$this->newAddr->stars()->get();
        foreach ($connectedStars as $singleStar){
            $check=$this->oldAddr->stars()->where('star', $singleStar->star)
                ->where('size', $singleStar->size)
                ->where('class', $singleStar->class)
                ->first();
            if($check){
                $differentPlanets=$this->checkPlanets($check, $singleStar);
                $this->addPlanets($differentPlanets, $check->id);
            }
            else {
                $this->addStar($singleStar);
            }
        }
        $this->updateInsides();
    }

    protected function checkPlanets($oldStar, $newStar)
    {
        $array=[];
        foreach($newStar->planets()->get() as $planet){
            $check=$oldStar->planets()->where('planet', $planet->planet)
                ->whereBetween('distance', [$planet->distance*0.99, $planet->distance*1.01])
                ->where('mark', $planet->mark)
                ->first();
            if($check) continue;
            else {
                $array[]=$planet->id;
            }
        }
        return $array;
    }

    protected function addStar($star)
    {
        $number=$this->oldAddr->stars()->count();
        switch($number){
            case 1:
                $code='B';
                break;
            case 2:
                $code='C';
                break;
            case 3:
                $code='D';
                break;
            case 4:
                $code='E';
                break;
            case 5:
                $code='F';
                break;
            default:
                $code='Z';
                break;
        }
        $star->address_id = $this->oldId;
        $star->code=$code;
        $star->save();
    }

    protected function addPlanets($differentPlanets, $oldStarId)
    {
        foreach($differentPlanets as $id){
            $planet=\App\Planet::find($id);
            $planet->star_id=$oldStarId;
            $planet->save();
        }
    }

    protected function updateInsides()
    {
        foreach($this->newAddr->discoveries()->get() as $one){
            $one->delete();
        }
        $this->newAddr->inside->delete();
        $this->newAddr->delete();
        $newData=\App\Myclasses\SystemInsider::rebuild($this->oldId);
        $this->oldAddr->inside->data=serialize($newData);
        $this->oldAddr->inside->save();
        $this->result=true;

    }

}