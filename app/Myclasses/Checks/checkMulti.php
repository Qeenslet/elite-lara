<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 02.09.2015
 * Time: 5:35
 */

namespace App\Myclasses\Checks;


class checkMulti extends Checker{

    protected $barycenters;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->address=\App\Address::find($data['address']);
        $this->checkExistence();
    }

    protected function checkExistence()
    {
        $number=$this->address->centers()->count();
        if($number>0)
        {
            $this->barycenters=$this->address->centers()->get();
            $this->checkEach();
        }
        else
        {
            $this->result=false;
        }
    }

    protected function checkEach()
    {
        $match=0;
        foreach($this->barycenters as $one)
        {
            foreach ($one->stars()->get() as $star)
            {
                if (in_array($star->id, $this->data['stars'])) $match+=1;
                else continue;
            }
        }
        if ($match>1) $this->result=true;
        else $this->result=false;
    }

}