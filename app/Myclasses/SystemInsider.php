<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12.07.2015
 * Time: 19:10
 */

namespace App\Myclasses;


class SystemInsider {
    public $stars;
    public $planets;
    public $regionId;
    public $addressId;
    public $fName;

    public function __construct($region, $address, $stars, $planets){
        $this->stars=$stars;
        $this->planets=$planets;
        $this->regionId=$region;
        $this->addressId=$address;
        $query=\App\Region::find($region);
        $this->fName=$query->name." ".$query->addresses()->find($address)->name;
    }

    public static function rebuild($id)
    {
        $address=\App\Address::find($id);
        $addressId=$id;
        $regionId=$address->region->id;
        $rawStars=$address->stars()->get();
        $stars=[];
        $planets=[];
        foreach($rawStars as $one){
            $star=$one->star;
            $size=$one->size;
            $class=$one->class;
            $code=$one->code;
            $user=$one->user_id;
            $stars[$one->id]=new \App\Myclasses\StarInfo($code, $star, $size, $class, $user);
            $planetsInside=[];
            foreach($one->planets()->get() as $ppp){
               $planet=$ppp->planet;
               $distance=$ppp->distance;
               $mark=$ppp->mark;
               $userP=$ppp->user_id;
               $planetsInside[$ppp->id]=new \App\Myclasses\PlanetInfo($planet, $distance, $mark, $userP);
            }
            $planets[$one->id]=$planetsInside;
            }
        return new self($regionId, $addressId, $stars, $planets);
    }
}