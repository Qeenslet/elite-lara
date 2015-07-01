<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 23.06.2015
 * Time: 14:33
 */

namespace App\Myclasses;


class CheckResult {
    public $data;
    public $code;
    public $smartCode;

    public $userId;
    public $regionId;
    public $addressId;
    public $starId;

    public $planDataId;
    public $starDataId;

    public $message;
    public $error;
    public $moderInfo;

    public function __construct($data){
        $this->data=$data;
        $this->planDataId=$this->starDataId=0;
    }
}