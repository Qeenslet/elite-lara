<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 23.08.2015
 * Time: 14:14
 */

namespace App\Myclasses\search;


class searchRare extends SearchEngine {
    protected $ids;
    protected $suitableStars;

    public function __construct($data)
    {
        $this->data=$data;
        $this->suitableStars=\App\Star::where('star', $this->data['rare_star'])->get();
        if($this->suitableStars) $this->search();
    }

    protected function search()
    {
        foreach($this->suitableStars as $one){
            $this->ids[]=$one->address->id;
        }
    }

    public function getIdsArray()
    {
        return $this->ids;
    }
}