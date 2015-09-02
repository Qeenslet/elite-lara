<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 02.09.2015
 * Time: 12:15
 */

namespace App\Myclasses\Insides;


class Terminator {

    private $address;
    private $stars;
    private $centers;
    private $findings;
    private $planets;

    public $result;

    public static function deleteAddress($id)
    {
        $terminator=new self($id);
        return $terminator->result;
    }
    private function __construct($id)
    {
        $this->address=\App\Address::find($id);
        $this->stars=$this->address->stars()->get();
        $this->findPlanets();
        if($this->centers=$this->address->centers()->count()>0)
        {
            $this->centers=$this->address->centers()->get();
            $this->findBaryPlanets();
        }
        $this->findings = $this->address->discoveries()->get();
        $this->terminate();
    }

    private function findPlanets()
    {
        foreach ($this->stars as $star)
        {
            foreach($star->planets()->get as $planet)
            {
                $this->planets[]=$planet;
            }
        }
    }

    private function findBaryPlanets()
    {
        foreach ($this->centers as $center)
        {
            foreach($center->planets()->get() as $planet)
            {
                $this->planets[]=$planet;
            }
        }
    }

    private function terminate()
    {
        \DB::beginTransaction();
        try {
            foreach ($this->stars as $star) {
                $star->delete();
            }
            foreach ($this->planets as $planet) {
                $planet->delete();
            }
            foreach ($this->findings as $one) {
                $one->delete();
            }
            $this->address->delete();
            \DB::commit();
            $this->result=true;
        }
        catch(\PDOException $e){
            \DB::rollback();
            $this->result=false;
        }
    }

}
