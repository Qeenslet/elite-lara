<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 28.08.2015
 * Time: 7:31
 */

namespace App\Myclasses\Insides;


class starInfo extends objectInfo {
    public $id;
    public $star;
    public $size;
    public $class;
    public $code;
    public $user;
    public $extra;

    public function __construct(\App\Star $star)
    {
        $this->id=$star->id;
        $this->star=$star->star;
        $this->size=$star->size;
        $this->class=$star->class;
        $this->code=$star->code;
        $this->user=$star->user_id;

        if($star->starData)
        {
            $this->extra = $star->starData->toArray();
        }
    }
}