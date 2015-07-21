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
    public $inside;

    public $starsIn;
    public $planetsIn;
    public $marks;
    public $starImages;
    public $planetImages;
    public $fName;


    public function __construct($id_address, $id_user=null){
        $this->address=$id_address;
        $inside=\App\Inside::where('address_id', $id_address)->first();
        $this->inside=unserialize($inside->data);
        $this->fName=$this->inside->fName;
        if($id_user!=null) $this->user=$id_user;
        $this->retrieve();
    }

    protected function retrieve(){
        $starName=Arrays::allStarsArray();
        $planetName=Arrays::planetsForCabinet();
        $sizeName=Arrays::sizeTypeArray();
        foreach($this->inside->stars as $id=>$star){
            $starDescription=$starName[$star->star].$star->class." ".$sizeName[$star->size];
            $this->starsIn[$id]=$starDescription;
            if(isset($this->user)) {
                if ($star->user!=$this->user) {
                    $this->marks[$id]='добавлена не вами';
                    $this->starImages[$id]='def.png';
                }
                else {
                    $this->marks[$id]='добавлена вами';
                    $this->starImages[$id]=$starName[$star->star].".png";
                }
            }
            else {
                $this->starImages[$id]=$starName[$star->star].".png";
            }
            $array=[];
            if (array_key_exists($id, $this->inside->planets)){
                foreach($this->inside->planets[$id] as $pId=>$planet){
                    if(isset($this->user)){
                    if($planet->user!=$this->user) continue;
                    }
                    $planetInfo=$planetName[$planet->planet]." - ".$planet->distance." ".$planet->mark;
                    $array[$pId]=$planetInfo;
                    $this->planetImages[$pId]=$planetName[$planet->planet].".png";
                }
            }
            $this->planetsIn[$id]=$array;
        }
    }

}