<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 28.08.2015
 * Time: 7:35
 */

namespace App\Myclasses\Insides;


class planetInfo extends objectInfo{

    public $id;
    public $planet;
    public $distance;
    public $mark;
    public $user;
    public $type;

    public function __construct(\Illuminate\Database\Eloquent\Model $planet)
    {
        $this->id=$planet->id;
        $this->planet=$planet->planet;
        $this->distance=$planet->distance;
        $this->mark=$planet->mark;
        $this->user=$planet->user_id;
        if($planet instanceof \App\Planet){
            $this->type='planet';
        }
        else $this->type='bari';
    }
}