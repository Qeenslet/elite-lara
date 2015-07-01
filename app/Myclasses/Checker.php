<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 23.06.2015
 * Time: 14:32
 */

namespace App\Myclasses;


use App\Region;

class Checker {
    protected $result;
    protected $data;
    protected $region;
    protected $address;
    protected $star;
    protected $failedPlanet;
    protected $stopper;

    protected function __construct($data){
        $this->data=$this->prepare($data);
        $this->result = new \App\Myclasses\CheckResult($this->data);
        $this->result->userId=\Auth::user()->id;
        $this->stopper=0;
        $this->checkRegion();
    }
    public static function checkIt($data){
        $check=new self($data);
        return $check->result;
    }

    protected function prepare($data){
        $newData=array_map(function($a){
            $a=strtoupper($a);
            $a=trim($a);
            $a=str_replace('  ', ' ', $a);
            return $a;
        }, $data);
        if(strlen($newData['one_name'])>0) {
            $newData['region']='SPECIAL';
            $newData['address']=$newData['one_name'];
            unset($newData['one_name']);
        }
        else {
            $newData['address']=$newData['code_name'];
            unset($newData['code_name']);
        }
        if(isset($data['planet'])) {
            $newData['mark'] = $data['mark'];
        }

        return $newData;
    }

    protected function checkRegion() {
        $region=Region::where('name', $this->data['region'])->first();
        if(!$region) {
            $this->result->code=0;
            if (isset($this->data['planet'])) {
                $this->smartCheck();
            }
        }
        else {
            $this->region=$region;
            $this->result->code=1;
            $this->result->regionId=$region->id;
            $this->checkAddress();
        }
    }

    protected function checkAddress(){
        $address=$this->region->addresses()->where('name', $this->data['address'])->first();
        if($address) {
            $this->address=$address;
            $this->result->code=2;
            $this->result->addressId=$address->id;
            $this->checkStar();
        }
        if (isset($this->data['planet'])) {
            $this->smartCheck();
        }
    }

    protected function checkStar() {
        $star=$this->address->stars()->where('star', $this->data['star'])
            ->where('size', $this->data['size'])
            ->where('class', $this->data['class'])
            ->first();
        if($star){
            $this->star=$star;
            $this->result->code=3;
            $this->result->starId=$star->id;
            if (isset($this->data['planet'])) {
                $this->checkPlanets();
            }
            else $this->inside();
        }
        if (isset($this->data['planet'])) {
            $this->smartCheck();
        }
    }

    protected function inside(){
        $this->result->code=4;
        $this->result->message=new \App\Myclasses\starSystemInfo($this->address->id);
    }

    protected function checkPlanets(){
       $planets=$this->star->planets()->get();
        if($planets){
            foreach($planets as $planet){
                $match=$this->checkPlanet($planet);
                if(!$match) continue;
                else {
                    $this->result->code=5;
                    $this->failedPlanet=$planet->id;
                    $this->fillResponse();
                }
            }
        }
        if($this->stopper==0) $this->smartCheck();
    }

    protected function checkPlanet($planet){
        if($planet->distance==$this->data['distance']) {
          if ($planet->mark==$this->data['mark']){
              if ($this->data['mark']=='sin') return true;
              return ($this->countNumbers());
          }
          if($this->data['mark']=='sat') return false;
        }
        return false;
    }

    protected function countNumbers(){
        $number=$this->star->planets()
            ->whereBetween('distance', [$this->data['distance']*0.95, $this->data['distance']*1.05])
            ->where('mark', $this->data['mark'])
            ->count();

        switch($this->data['mark']) {
            case 'bin':
                if($number>1) return true;
                break;
            case 'tri':
                if($number>2) return true;
                break;
            case 'qua':
                if($number>3) return true;
        }
        return false;
    }

    protected function fillResponse(){
        $planet=\App\Planet::find($this->failedPlanet);
        $now=\Carbon\Carbon::now();
        $date= new \Carbon\Carbon($planet->created_at);
        $past=$date->diffInDays($now);
        $pilot=$planet->user()->first();
        $response="Эта планета уже была внесена в базу данных пилотом ".$pilot->name." ".$past." дней назад";
        $this->result->error=$response;
        $this->stopper=1;
    }

    protected function smartCheck(){
        if($this->stopper!=1) {
            $star = $this->data['star'];
            if($this->data['planet']<4) $planets = [0,1,2,3];
            else $planets = [$this->data['planet']];
            $class = [$this->data['class']];
            $size = [$this->data['size']];

            $counter = new \App\Myclasses\Counter();

            $maxDistance = $counter->maxDistance($star, $size, $planets, $class);
            $minDistance = $counter->minDistance($star, $size, $planets, $class);

            $maxDistance *= 1.1;
            $minDistance *= 0.9;

            if ($this->data['distance'] < $maxDistance && $this->data['distance'] > $minDistance) {
                $step = $maxDistance / 10;
                $low = $this->data['distance'] - $step;
                $high = $this->data['distance'] + $step;
                $total = $counter->countPlanets($star, $planets, 100, $size, $class);
                $number = $counter->countDiapason($low, $high, $star, $planets, $size, $class);
                $percentage = $number / $total * 100;
                if ($percentage < 10) {
                    $this->result->smartCode = 2;
                    $this->result->moderInfo = ['status' => 'warning',
                        'total' => $total,
                        'number' => $number,
                        'percent' => round($percentage, 2)];
                } else {
                    $this->result->smartCode = 1;
                }
            } else {
                ($this->data['distance'] > $maxDistance) ? $differ = $this->data['distance'] - $maxDistance : $differ = $minDistance - $this->data['distance'];
                $this->result->smartCode = 3;
                $this->result->moderInfo = ['status' => 'danger',
                    'differ' => round($differ, 2)];
            }
        }
    }
}