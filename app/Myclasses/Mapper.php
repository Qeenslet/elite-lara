<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 04.08.2015
 * Time: 7:43
 */

namespace App\Myclasses;


class Mapper {

    protected $objectCollection;
    public $countries;
    public $cities;
    public $cityCounts;

    public function __construct($queryResults)
    {
        foreach($queryResults as $one){
            $this->objectCollection[]=unserialize($one->content);
        }
        $this->sortOut();
    }

    protected function sortOut()
    {
        foreach ($this->objectCollection as $singleObject){

            if(array_key_exists('country', $singleObject)){
                if(array_key_exists('iso', $singleObject['country'])){
                    $this->saveCountry($singleObject['country']['id'], $singleObject['country']['iso']);
                }
            }
            if(array_key_exists('city', $singleObject)){
                if(array_key_exists('id', $singleObject['city'])){
                    $this->saveCity($singleObject['city']);
                }
            }
        }
    }

    protected function saveCountry($id, $iso){
        $this->countries[$id]=$iso;
    }

    protected function saveCity(array $city){
        $add=$this->increment($city['id']);
        if($add){
            $this->cities[]=$city;
        }

    }

    protected function increment($id){
        if(isset($this->cityCounts[$id])){
            $this->cityCounts[$id]+=1;
            return false;
        }
        else {
            $this->cityCounts[$id]=1;
            return true;
        }
    }
}