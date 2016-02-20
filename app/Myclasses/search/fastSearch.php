<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 16.02.2016
 * Time: 21:20
 */

namespace App\Myclasses\search;


class fastSearch {

    private $low;
    private $high;
    private $percent = 0.1;
    private $planets = [0,1,2,3];
    private $sizes = [0,1,2,3,4,5,6,7];
    private $temperatures = [0,1,2,3,4,5,6,7,8,9];
    private $star;
    private $counter;
    private $theDistance;
    private $result;
    public $empty;
    private $total;

    public function __construct($data)
    {
        $this->makeHighLow($data['distance'] / $data['units']);
        $this->counter = new \App\Myclasses\Counter();
        $this->star = [$data['star']];
        if ($data['planet'] != 'tf') $this->planets = [$data['planet']];
        if (isset($data['size']) && $data['sizes'] != 100) $this->sizes = [$data['size']];
        if (isset($data['temperature']) && $data['temperature'] != 100) $this->temperatures = [$data['temperature']];
        $this->defineLimits();
    }

    private function makeHighLow($distance)
    {
        $this->high = $distance * (1 + $this->percent);
        $this->low = $distance * (1 - $this->percent);
    }

    private function calculate()
    {
        $number = $this->counter->countDiapason($this->low, $this->high, $this->star, $this->planets, $this->sizes, $this->temperatures);
        if ($this->theDistance != 0)
        {
            $density1 = $this->total / $this->theDistance;
            $density2 = $number / ($this->high - $this->low);
            $this->result = round($density2 / $density1, 2);
        }
        else
        {
            $this->result = 0;
        }
    }

    private function defineLimits()
    {
        $maxDistance = $this->counter->maxDistance($this->star, $this->sizes, $this->planets, $this->temperatures);
        $minDistance = $this->counter->minDistance($this->star, $this->sizes, $this->planets, $this->temperatures);
        $this->total = $this->counter->countPlanets($this->star, $this->planets, 100, $this->sizes, $this->temperatures);
        $this->theDistance = $maxDistance - $minDistance;
        if ($this->total == 0) $this->empty = 1;
        if ($this->low >= $minDistance && $this->high <= $maxDistance) $this->calculate();
        else $this->result = 0;
    }

    public function getResult()
    {
        return $this->result;
    }
}