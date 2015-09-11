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

class charterThree extends charterParent {
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
    protected $addr;
    protected $nameStyle;

    public function __construct($data){
        parent::__construct();
        $this->counter=new Counter();

        $this->starsArray=Arrays::allStarsArray();
        $this->sizeArray=Arrays::sizeTypeArray();
        $this->planetTypeArray=Arrays::planetTypeArray();

        $this->star=$data['star'];
        ($data['size']==999) ? $this->size=[0,1,2,3,4,5,6,7] : $this->size=[$data['size']];
        ($data['class']==999) ? $this->class=[0,1,2,3,4,5,6,7,8,9] : $this->class=[$data['class']];

        if($data['size']==999 && $data['class']==999) {
            $this->addr=$this->starsArray[$data['star']];
            $this->nameStyle='all-all';

        }
        if ($data['size']==999 && $data['class']!=999) {
            $this->addr=$this->starsArray[$data['star']].$data['class'];
            $this->nameStyle='all-size';
        }
        if ($data['size']!=999 && $data['class']==999) {
            $this->addr=$this->starsArray[$data['star']]." ".$this->sizeArray[$data['size']];
            $this->nameStyle='all-class';
        }
        if($data['size']!=999 && $data['class']!=999) {
            $this->addr=$this->starsArray[$data['star']].$data['class']." ".$this->sizeArray[$data['size']];
            $this->nameStyle='one-one';
        }
        $this->name=$this->thirdChartName($this->locale, $this->nameStyle);
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
    protected function thirdChartName($locale, $type)
    {
        $header_en='Orbits of planets in the systems ';
        $headers_en=['all-all'=>' of all sizes and temperature classes',
            'all-size'=>' of all sizes',
            'all-class'=>' of all temperature classes',
            'one-one'=>''];
        $header_ru='Орбиты обнаруженных планет в системах ';
        $headers_ru=['all-all'=>' всех размеров и температурных подклассов',
            'all-size'=>'всех размеров',
            'all-class'=>' всех температурных подклассов',
            'one-one'=>''];

        switch($locale)
        {
            case 'ru':
                $string=$header_ru;
                $array=$headers_ru;
                break;
            case 'en':
                $string=$header_en;
                $array=$headers_en;
                break;
        }
        return $string.$this->addr.$array[$type];

    }

    function changeLocale($locale)
    {
        $pairs=Arrays::translate($locale);
        $this->name=$this->thirdChartName($locale, $this->nameStyle);
        $array=[];
        foreach($this->result as $key=>$value)
        {
            $newKey=$pairs[$key];
            $array[$newKey]=$value;
        }
        $this->result=$array;
        $array2=[];
        foreach($this->total as $key=>$value)
        {
            $newKey=$pairs[$key];
            $array2[$newKey]=$value;
        }
        $this->total=$array2;
        $this->planetTypeArray=Arrays::planetTypeArray();
    }
}