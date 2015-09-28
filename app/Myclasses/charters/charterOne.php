<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 22.06.2015
 * Time: 4:41
 */

namespace App\Myclasses\charters;


use App\Myclasses\Arrays;
use App\Myclasses\Counter;

class charterOne extends charterParent{
    public $inHeader;
    public $tempHeader;
    public $result;
    public $charType;
    public $starHeader;
    public $sizeHeader;
    public $planetTypeArray;
    public $anything;

    protected $counter;
    protected $star;
    protected $size;
    protected $class;
    protected $planet;
    protected $step;
    protected $nameSize;
    protected $nameClass;
    protected $chartSelection;

    public function __construct($data){
        parent::__construct();
        $this->counter = new Counter();
        $this->planetTypeArray=Arrays::planetTypeArray();
        $starsArray=Arrays::allStarsArray();
        $sizeArray=Arrays::sizeTypeArray();

        if ($data['size']==100) {
            $this->nameSize='size-all';
            $this->size=[0,1,2,3,4,5,6,7];
        }
        else {
            $this->nameSize='size-one';
            $this->sizeHeader=$sizeArray[$data['size']];
            $this->size=[$data['size']];
        }
        if($data['class']==100) {
            $this->nameClass='class-all';
            $this->class=array(0,1,2,3,4,5,6,7,8,9);
        }
        else {
            $this->tempHeader=$data['class'];
            $this->nameClass='class-one';
            $this->class=[$data['class']];
        }

        $this->star=$data['star'];
        $this->starHeader=$starsArray[$data['star']];

        ($data['step']==0) ? $this->step=0.25 : $this->step=$data['step'];
        switch($data['planet']){
            case 3:
                $this->planet=[3];
                $this->chartSelection='el';
                $this->charType=1;
                $this->querySimple();
                break;
            case 3210:
                $this->planet=[0, 1, 2, 3];
                $this->chartSelection='eltf';
                $this->charType=1;
                $this->querySimple();
                break;
            case 14:
                $this->planet=[1, 4];
                $this->chartSelection='ww';
                $this->charType=1;
                $this->querySimple();
                break;
            case 543210:
                $this->chartSelection='all';
                $this->charType=2;
                $this->queryAll();
        }
        $this->headerName($this->locale);
    }

    protected function querySimple(){
        $result=$this->counter->queryDiapason($this->star, $this->planet, $this->step, $this->size, $this->class);
        if (!$result) $this->anything=0;
        else {
            $this->result=$result;
            $this->anything=1;
        }
    }

    protected function queryAll(){
        $result=[];
        for($i=0, $n=count($this->planetTypeArray); $i<$n; $i++){
            $planet=[$i];
            $query=$this->counter->queryDiapason($this->star, $planet, $this->step, $this->size, $this->class);
            if($query) $result[$i]=$query;
            else continue;
        }
        if(!$result) $this->anything=0;
        else {
            $this->result=$result;
            $this->anything=1;
        }
    }

    protected function headerName($locale)
    {
        $ru=['el'=>'земные', 'eltf'=>'земные и пригодные к ТФ', 'ww'=>'водные всех типов', 'all'=>'все возможные'];
        $en=['el'=>'Earth-likes planets', 'eltf'=>'Earth-likes and TF suitable', 'ww'=>'water worlds of all types', 'all'=>'all available'];
        if($locale=='en')
        {
            if ($this->nameClass == 'class-all') $this->tempHeader = '';
            if ($this->nameSize == 'size-all') $this->sizeHeader = '';
            $this->inHeader=$en[$this->chartSelection];
        }
        if($locale=='ru')
        {
            if ($this->nameClass == 'class-all') $this->tempHeader = 'все температурные подклассы';
            if ($this->nameSize == 'size-all') $this->sizeHeader = 'все размеры';
            $this->inHeader=$ru[$this->chartSelection];

        }
    }

    function changeLocale($locale)
    {
        $this->headerName($locale);
        $this->planetTypeArray=Arrays::planetTypeArray();

    }
}