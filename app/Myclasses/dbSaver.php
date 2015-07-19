<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 25.06.2015
 * Time: 3:58
 */

namespace App\Myclasses;


use App\Myclasses\PlanetInfo;
use App\Myclasses\StarInfo;
use DB;
use League\Flysystem\Exception;

class dbSaver {
    protected $systemData;
    protected $result;
    protected $planetId;

    protected function __construct(CheckResult $data){
        $this->systemData=$data;
        DB::beginTransaction();
        try {
            switch ($this->systemData->code) {
                case 0:
                    $this->saveRegion();
                case 1:
                    $this->saveAddress();
                case 2:
                    $this->saveStar();
                case 3:
                    if (isset($this->systemData->data['planet'])) $this->savePlanet();
                    else break;
            }
            $this->savePoints();
            $this->saveInsides();
            $this->saveStats();
            DB::commit();
            $this->result = 1;
        }
        catch (\PDOException $e){
            DB::rollback();
            $this->result=0;
            //сюда всунуть функцию, которая отправит письмо мне!!!
        }
    }

    public static function save(CheckResult $data){
        $saver = new self($data);
        if($saver->result==1) return $saver->systemData;
        else return false;
    }

    protected function saveRegion(){
       $region = \App\Region::create(['name' => $this->systemData->data['region']]);
       $this->systemData->regionId = $region->id;
    }

    protected function saveAddress(){
        $address = \App\Address::create(['name' => $this->systemData->data['address'],
                'region_id' => $this->systemData->regionId]);
        $this->systemData->addressId = $address->id;

    }

    protected function saveStar(){
        $array = ['star' => $this->systemData->data['star'],
                'size' => $this->systemData->data['size'],
                'class' => $this->systemData->data['class'],
                'address_id' => $this->systemData->addressId,
                'user_id' => $this->systemData->userId,
                'code'=>$this->systemData->data['code'],
                'stardata_id' => $this->systemData->starDataId];
        $star = \App\Star::create($array);
        $this->systemData->starId = $star->id;

    }

    protected function savePlanet(){
        $array = ['star_id' => $this->systemData->starId,
                'planet' => $this->systemData->data['planet'],
                'mark' => $this->systemData->data['mark'],
                'distance' => $this->systemData->data['distance'],
                'user_id' => $this->systemData->userId,
                'plandata_id' => $this->systemData->planDataId];
        $planet=\App\Planet::create($array);
        $this->planetId=$planet->id;

    }

    protected function savePoints(){
        $user = \App\User::find($this->systemData->userId);

        if ($user) {
            $valueStar=$valuePlanet=0;
            if ($this->systemData->code<3) {
                 $starV = \App\StarsValue::where('star', $this->systemData->data['star'])->first();
                 $user->points()->increment('stars', 1);
                 $valueStar = $starV->value * $starV->modifier;
             }
             if (isset($this->systemData->data['planet'])) {
                    $planetV = \App\PlanetsValue::where('planet', $this->systemData->data['planet'])->first();
                    $valuePlanet = $planetV->value * $planetV->modifier;
                    $user->points()->increment('planets', 1);
             }
            $value=$valuePlanet+$valueStar;
            if($value>0) {
                $user->points()->increment('points', $value);
            }
             $findings=$user->findings()->where('address_id', $this->systemData->addressId)->first();
             if(!$findings){
                 $findingSave= new \App\Finding(['address_id'=>$this->systemData->addressId]);
                 $user->findings()->save($findingSave);
             }

            }
    }

    protected function saveInsides(){
        $insider=\App\Inside::where('address_id', $this->systemData->addressId)->first();
        if(!$insider) {
            $addr = $this->systemData->addressId;
            $reg = $this->systemData->regionId;
            $planets = [];
            $stars[$this->systemData->starId] = new StarInfo($this->systemData->data['code'],
                $this->systemData->data['star'],
                $this->systemData->data['size'],
                $this->systemData->data['class'],
                $this->systemData->userId);
            if (isset($this->systemData->data['planet'])) {
                $planets[$this->systemData->starId][$this->planetId] = new PlanetInfo($this->systemData->data['planet'],
                    $this->systemData->data['distance'],
                    $this->systemData->data['mark'],
                    $this->systemData->userId);
            }
            $data = new \App\Myclasses\SystemInsider($reg, $addr, $stars, $planets);
            $sData = serialize($data);
            \App\Inside::create(['address_id' => $addr, 'data' => $sData]);
        }
        else {
            $data=unserialize($insider->data);
            $data->stars[$this->systemData->starId] = new StarInfo($this->systemData->data['code'],
                $this->systemData->data['star'],
                $this->systemData->data['size'],
                $this->systemData->data['class'],
                $this->systemData->userId);
            if (isset($this->systemData->data['planet'])) {
                $data->planets[$this->systemData->starId][$this->planetId] = new PlanetInfo($this->systemData->data['planet'],
                    $this->systemData->data['distance'],
                    $this->systemData->data['mark'],
                    $this->systemData->userId);
            }
            $sData=serialize($data);
            $insider->data=$sData;
            $insider->save();
        }
    }
    protected function saveStats(){
        $today=\Carbon\Carbon::today();
        $now=\Carbon\Carbon::now();
        $statistics=\App\Statcache::whereBetween('created_at', [$today, $now])->first();
        switch($this->systemData->code){
            case 0:
                $statistics->latest_regions+=1;
                $statistics->regions+=1;
            case 1:
                $statistics->latest_addresses+=1;
                $statistics->addresses+=1;
            case 2:
                $statistics->latest_stars+=1;
            case 3:
                if(isset($this->systemData->data['planet'])){
                    $statistics->latest_planets+=1;
                    $statistics->planets+=1;
                    if($this->systemData->data['planet']<4) $statistics->tf+=1;
                }
        }
        $statistics->save();
    }
}