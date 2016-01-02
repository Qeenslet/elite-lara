<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 27.12.2015
 * Time: 15:24
 */

namespace App\Myclasses\search;


class cabinetSearch extends searchByParams {

    private $planet;
    private $star;
    private $user;

    public function __construct($data)
    {
        $this->planet = (int)$data['planet'];
        $this->star = (int)$data['star'];
        $this->user = \Auth::user();
        $this->search();
    }

    private function search()
    {
        $suitablePlanets = $this->user->planets()->where('planet', $this->planet)->get();
        $suitableStars = [];
        foreach($suitablePlanets as $one)
        {
            if ($one->star->star != $this->star)
                continue;
            $suitableStars[]=$one->star;
        }
        foreach($suitableStars as $oneStar)
        {
            $this->ids[]=$oneStar->address->id;
        }
    }
}