<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 26.08.2015
 * Time: 13:18
 */

namespace App\Myclasses\Checks;


class Checker {
    protected $data;
    public $result;
    protected $address;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->prepare();
    }

    protected function prepare()
    {
        $newData=array_map(function($a){
            $a=strtoupper($a);
            $a=trim($a);
            $a=str_replace('  ', ' ', $a);
            return $a;
        }, $this->data);
        if (isset($this->data['one_name']) || isset($this->data['region'])) {
            if (strlen($newData['one_name']) > 0) {
                $newData['region'] = 'SPECIAL';
                $newData['address'] = $newData['one_name'];
                unset($newData['one_name']);
            } else {
                $newData['address'] = $newData['code_name'];
                unset($newData['code_name']);
            }
        }
        if(isset($this->data['planet'])) {
            $newData['mark'] = $this->data['mark'];
            if($this->data['distance']<5 && $this->data['units']==500) $this->data['units']=1;
            $newData['distance']=$this->data['distance']/$this->data['units'];
        }
        $this->data=$newData;
    }
    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return \Illuminate\Support\Collection|null|static
     */
    public function getAddress()
    {
        return $this->address;
    }

    public function setUserData($user_id)
    {
        $this->data['user']=$user_id;
    }

    public function getAddressId()
    {
        return $this->address->id;
    }

}