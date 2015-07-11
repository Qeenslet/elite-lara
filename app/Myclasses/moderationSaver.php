<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 25.06.2015
 * Time: 13:17
 */

namespace App\Myclasses;


class moderationSaver {
    protected $checkResult;
    protected $checkCopy;
    protected $resultString;
    protected $user_id;
    protected $type;
    protected $address;

    protected $result;

    protected function __construct(CheckResult $result){
        $this->checkResult=$result;
        $this->checkCopy=clone $this->checkResult;
        $this->address=$result->data['region']." ".$result->data['address'];
        $this->resultString=serialize($result);
        $this->user_id=$result->userId;
        $this->type=$result->moderInfo['status'];
        $this->result=0;
        $this->checkStar();
    }

    public static function save(CheckResult $result){
        $saver=new self($result);
        if ($saver->result==2) return $saver->checkResult;
        else return false;
    }

    protected function checkStar(){
        if($this->checkResult->code<3){
            unset ($this->checkCopy->data['planet']);
            $save=\App\Myclasses\dbSaver::save($this->checkCopy);
            if($save)
            {
                $this->checkResult->code=3;
                $this->checkResult->starId=$save->starId;
                $this->checkResult->regionId=$save->regionId;
                $this->checkResult->addressId=$save->addressId;
                $this->resultString=serialize($this->checkResult);
                $this->writeIn();
            }
            else $this->result=1;
        }
        else if($this->result==0) $this->writeIn();
    }

    protected function writeIn(){
        $array=['type'=>$this->type,
                'user_id'=>$this->user_id,
                'data'=>$this->resultString,
                'address'=>$this->address];
        $save=\App\Moderation::create($array);
        if ($save) $this->result=2;
        else $this->result=1;
    }
}