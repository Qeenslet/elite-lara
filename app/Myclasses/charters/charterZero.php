<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 22.06.2015
 * Time: 5:11
 */

namespace App\Myclasses\charters;


class charterZero {
    public $result;

    public function __construct(){
        $counter= new \App\Myclasses\Counter;
        $this->result=$counter->zeroChart();
    }
}