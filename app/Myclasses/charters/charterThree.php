<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 22.06.2015
 * Time: 6:05
 */

namespace App\Myclasses\charters;


use App\Myclasses\Arrays;
use App\Myclasses\Counter;

class charterThree {
    public $result;
    public $name;
    public $planetTypeArray;
    public $total;

    protected $star;
    protected $size;
    protected $class;
    protected $starsArray;
    protected $sizeArray;
    protected $counter;
    protected $param;

    public function __construct($data){
        $this->counter=new Counter();

        $this->starsArray=Arrays::allStarsArray();
        $this->sizeArray=Arrays::sizeTypeArray();
        $this->planetTypeArray=Arrays::planetTypeArray();

        $this->star=$data['star'];
        ($data['size']==999) ? $this->size=[0,1,2,3,4,5,6,7] : $this->size=[$data['size']];
        ($data['class']==999) ? $this->class=[0,1,2,3,4,5,6,7,8,9] : $this->class=[$data['class']];

        if($data['size']==999 && $data['class']==999) {
            $addr=$this->starsArray[$data['star']];
            $this->name="Орбиты обнаруженных планет в системах $addr всех размеров и температурных подклассов";
        }
        if ($data['size']==999 && $data['class']!=999) {
            $addr=$this->starsArray[$data['star']].$data['class'];
            $this->name="Орбиты обнаруженных планет в системах $addr всех размеров";
        }
        if ($data['size']!=999 && $data['class']==999) {
            $addr=$this->starsArray[$data['star']]." ".$this->sizeArray[$data['size']];
            $this->name="Орбиты обнаруженных планет в системах $addr всех температурных подклассов";
        }
        if($data['size']!=999 && $data['class']!=999) {
            $addr=$this->starsArray[$data['star']].$data['class']." ".$this->sizeArray[$data['size']];
            $this->name="Орбиты обнаруженных планет в системах $addr";
        }
        $this->count();
    }
    protected function count(){
        for ($i=0; $i<count($this->planetTypeArray); $i++) {
            $name=$this->planetTypeArray[$i];
            $ask=$this->counter->orbitCount($this->star, $this->size, $this->class, [$i]);
            $totalNum=$this->counter->countPlanets($this->star, [$i], 100, $this->size, $this->class);
            $this->total[$name]=$totalNum;
            if(!$ask) continue;
            $this->result[$name]=$ask;
        }
    }
}