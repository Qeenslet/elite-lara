<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 26.08.2015
 * Time: 13:26
 */

namespace App\Myclasses\Checks;


class checkAddr extends \App\Myclasses\Checks\Checker{

    protected $region;

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->checkRegion();
    }

    protected function checkRegion()
    {
        $region=\App\Region::where('name', $this->data['region'])->first();
        if(!$region) {
            $this->result=false;
        }
        else {
            $this->region=$region;
            $this->checkAddress();
        }
    }

    protected function checkAddress()
    {
        $address=$this->region->addresses()->where('name', $this->data['address'])->first();
        if($address) {
            $this->result=$address->id;
        }
        else {
            $this->result=false;
        }
    }

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }

}