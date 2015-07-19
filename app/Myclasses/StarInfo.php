<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12.07.2015
 * Time: 19:13
 */

namespace App\Myclasses;


class StarInfo {
    public $star;
    public $size;
    public $class;
    public $code;
    public $user;

    function __construct($code, $star, $size, $class, $user)
    {
        $this->code = $code;
        $this->star = $star;
        $this->size = $size;
        $this->class = $class;
        $this->user = $user;
    }
    public static function getFromDb($id)
    {
        $data=\App\Star::find($id);
        $newStar = new self($data->code, $data->star, $data->size, $data->class, $data->user);
        return $newStar;
    }
}