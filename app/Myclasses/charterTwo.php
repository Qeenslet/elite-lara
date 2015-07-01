<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 22.06.2015
 * Time: 5:42
 */

namespace App\Myclasses;


use App\Myclasses\Arrays;
use App\Myclasses\Counter;

class charterTwo {
    public $title;
    public $d_1;
    public $d_2;
    public $d_3;

    protected $total;
    protected $planets;
    protected $stopList;
    protected $starsList;
    protected $sizeList;
    protected $counter;
    protected $starsArray;
    protected $sizeArray;

    public function __construct($data){
        switch ($data['style']) {
            case 1:
                $this->planets = [0, 1, 2, 3];
                $this->title="Распределение всех пригодных для жизни планет по типам звезд";
                break;
            case 2:
                $this->planets = [0];
                $this->title="Распределение т-металлик планет по типам звезд";
                break;
            case 3:
                $this->planets = [1];
                $this->title="Распределение т-водных планет по типам звезд";
                break;
            case 4:
                $this->planets = [4];
                $this->title="Распределение водных планет по типам звезд";
                break;
            case 5:
                $this->planets = [5];
                $this->title="Распределение аммиачных планет по типам звезд";
                break;
            case 6:
                $this->planets = [3];
                $this->title="Распределение планет земного типа по типам звезд";
                break;
        }
        $this->counter=new Counter();

        $this->sizeList=$this->counter->starSelect('size');
        $this->stopList=Arrays::stopList();
        $this->starsArray=Arrays::allStarsArray();
        $this->sizeArray=Arrays::sizeTypeArray();

        $this->total=$this->counter->planetSelect($this->planets);
        $this->starsList=$this->counter->starSelectExcluding($this->stopList);

        $this->searchNormal();
    }

    protected function searchNormal(){
        foreach($this->starsList as $singleStar) {
            $Sname=$this->starsArray[$singleStar];
            $this->d_1[$Sname]=$this->counter->countPlanets($singleStar, $this->planets, $this->total);
            //второй слой данных
            foreach ($this->sizeList as $size) {
                $Ssize=$this->sizeArray[$size];
                $ask=$this->counter->countPlanets($singleStar, $this->planets, $this->total, [$size]);
                if($ask>0) $this->d_2[$Sname][$Ssize]=$ask;

                //третий слой данных
                for ($i=0; $i<10; $i++){
                    $ask=$this->counter->countPlanets($singleStar, $this->planets, $this->total, [$size], [$i]);
                    if($ask>0) $this->d_3[$Sname][$Ssize][$Sname.$i]=$ask;
                }
            }
        }
        $this->searchSpecial();
    }

    protected function searchSpecial(){
        $this->d_1['редкие']=$this->counter->countRare($this->planets, $this->total);
        foreach ($this->stopList as $star) {
            $Sname=$this->starsArray[$star];
            $this->d_2['редкие'][$Sname]=$this->counter->countPlanets($star, $this->planets, $this->total);
        }
    }
}