<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 30.08.2015
 * Time: 15:14
 */

namespace App\Myclasses\Checks;


class checkStar extends Checker{

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->address=\App\Address::find($data['address']);
        $this->checkStar();

    }

    protected function checkStar() {
        $star=$this->address->stars()
            ->where('star', $this->data['star'])
            ->where('size', $this->data['size'])
            ->where('class', $this->data['class'])
            ->where('code', $this->data['code'])
            ->first();
        if($star){
            $this->result=true;
        }
        else
            $this->checkCode();
    }

    protected function checkCode(){
        $num=$this->address->stars()->where('code', $this->data['code'])->count();
        if($num==0){
            $this->result=false;
        }
        else {
            $this->result=true;
        }
    }


}