<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 22.06.2015
 * Time: 5:42
 */

namespace App\Myclasses\charters;


use App\Myclasses\Arrays;
use App\Myclasses\Counter;

class charterTwo extends charterParent{
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
    protected $chartSelection;

    public function __construct($data){
        parent::__construct();
        switch ($data['style']) {
            case 1:
                $this->planets = [0, 1, 2, 3];
                $this->chartSelection='life';

                break;
            case 2:
                $this->planets = [0];
                $this->chartSelection='metal';

                break;
            case 3:
                $this->planets = [1];
                $this->chartSelection='tw';

                break;
            case 4:
                $this->planets = [4];
                $this->chartSelection='w';

                break;
            case 5:
                $this->planets = [5];
                $this->chartSelection='aw';

                break;
            case 6:
                $this->planets = [3];
                $this->chartSelection='el';

                break;
        }
        $this->chartName($this->locale);
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

    protected function chartName($locale)
    {
        $ru=['life'=>'Распределение всех пригодных для жизни планет по типам звезд',
            'metal'=>'Распределение т-металлик планет по типам звезд',
            'tw'=>'Распределение т-водных планет по типам звезд',
            'w'=>'Распределение водных планет по типам звезд',
            'aw'=>'Распределение аммиачных планет по типам звезд',
            'el'=>'Распределение планет земного типа по типам звезд'];
        $en=['life'=>'Spreading of all life-suitable planets by star types',
            'metal'=>'Spreading of T-high metal planets by star types',
            'tw'=>'Spreading of T-water worlds by star types',
            'w'=>'Spreading of water worlds by star types',
            'aw'=>'Spreading of ammonia worlds by star types',
            'el'=>'Spreading of Earth-like planets by star types'];
        switch($locale)
        {
            case 'ru':
                $this->title=$ru[$this->chartSelection];
                break;
            case 'en':
                $this->title=$en[$this->chartSelection];
                break;
        }

    }

    function changeLocale($locale)
    {
        $this->chartName($locale);
    }
}