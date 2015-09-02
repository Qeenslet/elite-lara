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

class charterOne {
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

    public function __construct($data){
        $this->counter = new Counter();
        $this->planetTypeArray=Arrays::planetTypeArray();
        $starsArray=Arrays::allStarsArray();
        $sizeArray=Arrays::sizeTypeArray();

        if ($data['size']==100) {
            $this->sizeHeader="все размеры";
            $this->size=[0,1,2,3,4,5,6,7];
        }
        else {
            $this->sizeHeader=$sizeArray[$data['size']];
            $this->size=[$data['size']];
        }
        if($data['class']==100) {
            $this->tempHeader="все температурные подклассы";
            $this->class=array(0,1,2,3,4,5,6,7,8,9);
        }
        else {
            $this->tempHeader=$data['class'];
            $this->class=[$data['class']];
        }

        $this->star=$data['star'];
        $this->starHeader=$starsArray[$data['star']];

        ($data['step']==0) ? $this->step=0.25 : $this->step=$data['step'];
        switch($data['planet']){
            case 3:
                $this->planet=[3];
                $this->inHeader="земные";
                $this->charType=1;
                $this->querySimple();
                break;
            case 3210:
                $this->planet=[0, 1, 2, 3];
                $this->inHeader="земные и пригодные к ТФ";
                $this->charType=1;
                $this->querySimple();
                break;
            case 14:
                $this->planet=[1, 4];
                $this->inHeader="водные всех типов";
                $this->charType=1;
                $this->querySimple();
                break;
            case 543210:
                $this->inHeader="все возможные";
                $this->charType=2;
                $this->queryAll();
        }
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
        for($i=0; $i<count($this->planetTypeArray); $i++){
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
}