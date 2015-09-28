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
        foreach($suitablePlanets as $one){
            $suitableStars=$one->star()->where('star', $this->data['star'])
                ->where('size', $this->data['size'])
                ->where('class', $this->data['class'])
                ->get();
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