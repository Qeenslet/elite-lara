<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 23.08.2015
 * Time: 13:28
 */

namespace App\Myclasses\search;


class searchByParams extends SearchEngine{
    protected $ids;

    public function __construct($data)
    {
        $this->data=$data;
        $this->data['distance'] = str_replace(',', '.', $data['distance']);
        $this->search();
    }
    private function search()
    {
        $suitablePlanets=\App\Planet::where('planet', $this->data['planet'])
            ->whereBetween('distance', [$this->data['distance']*0.99, $this->data['distance']*1.01])
            ->get();
        $suitableStars = [];
        foreach($suitablePlanets as $one){
            if ($one->star->star != $this->data['star'])
                continue;
            if($one->star->class != $this->data['class'])
                continue;
            if ($one->star->size !=$this->data['size'])
                continue;
            $suitableStars[]=$one->star;
        }
        foreach($suitableStars as $oneStar){
            $this->ids[]=$oneStar->address->id;

        }
    }
    public function getIdsArray()
    {
        return $this->ids;
    }
}