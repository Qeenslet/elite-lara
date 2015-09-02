<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 02.09.2015
 * Time: 15:09
 */

namespace App\Myclasses\Savers;


class Deleter extends Rewriter{

    public function __construct($object, $data)
    {
        parent::__construct($object, $data);
    }

    protected function changeStar()
    {
        foreach($this->toChange->planets()->get() as $planet)
        {
            $planet->delete();
        }
        $this->toChange->delete();
    }

    protected function changePlanet()
    {
        $this->toChange->delete();
    }
}