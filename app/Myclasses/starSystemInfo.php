<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 24.06.2015
 * Time: 9:15
 */

namespace App\Myclasses;


use App\Myclasses\Arrays;

class starSystemInfo {
    public $address;
    protected $user;

    protected $stars;

    public $starsIn;
    public $planetsIn;
    public $marks;
    public $starImages;
    public $planetImages;
    public $fName;


    public function __construct($id_address, $id_user=null){
        $this->address=$id_address;
        $addr=\App\Address::find($id_address);
        $this->fName=$addr->region->name." ".$addr->name;
        if($id_user!=null) $this->user=$id_user;
        $this->selectStars();
    }

    protected function selectStars(){
        $this->stars=\App\Address::find($this->address)->stars()->get();
        $this->compile();
    }

    protected function compile(){
        $starName=Arrays::allStarsArray();
        $planetName=Arrays::planetsForCabinet();
        $sizeName=Arrays::sizeTypeArray();
        foreach($this->stars as $star){
            $starDescription=$starName[$star->star].$star->class." ".$sizeName[$star->size];
            $this->starsIn[$star->id]=$starDescription;
            if(isset($this->user)) {
               $planets = $star->planets()->where('user_id', $this->user)->get();

                if ($star->user_id!=$this->user) {
                    $this->marks[$star->id]='добавлена не вами';
                    $this->starImages[$star->id]='def.png';
                }
                else {
                    $this->marks[$star->id]='добавлена вами';
                    $this->starImages[$star->id]=$starName[$star->star].".png";
                }
           }
            else {
                $planets=$star->planets()->get();
                $this->starImages[$star->id]=$starName[$star->star].".png";
            }
            if (!$planets) continue;
            $array=[];
            foreach ($planets as $planet){
               $planetInfo=$planetName[$planet->planet]." - ".$planet->distance." ".$planet->mark;
                $array[$planet->id]=$planetInfo;
                $this->planetImages[$planet->id]=$planetName[$planet->planet].".png";
            }
            $this->planetsIn[$star->id]=$array;
        }
    }

}