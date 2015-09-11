<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 22.06.2015
 * Time: 5:11
 */

namespace App\Myclasses\charters;


class charterZero extends charterParent{
    public $result;

    public function __construct(){
        parent::__construct();
        $counter= new \App\Myclasses\Counter;
        $this->result=$counter->zeroChart();
    }

    function changeLocale($locale)
    {
        $pairs=\App\Myclasses\Arrays::translate($locale);
        $array=[];
        foreach($this->result as $key=>$value)
        {
            $newKey=$pairs[$key];
            $array[$newKey]=$value;
        }
        $this->result=$array;
    }
}