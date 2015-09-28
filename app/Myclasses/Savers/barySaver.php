<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 01.09.2015
 * Time: 11:49
 */

namespace App\Myclasses\Savers;


class barySaver extends planetSaver{

    protected function savePlanet(){
        $array = ['baricenter_id' => $this->star->id,
            'planet' => $this->data['planet'],
            'mark' => $this->data['mark'],
            'distance' => $this->data['distance'],
            'user_id' => $this->user];
        $planet=\App\Bariplanet::create($array);
        $this->planetId=$planet->id;

    }
}