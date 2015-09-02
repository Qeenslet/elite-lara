<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 31.08.2015
 * Time: 10:16
 */

namespace App\Myclasses\Checks;


class checkPlanet extends Checker{

    protected $centerObject;
    protected $smartCheckMessage;


    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->address=\App\Address::find($data['address']);

        switch($data['object'])
        {
            case 'star':
                $this->centerObject=\App\Star::find($data['objectId']);
                break;
            case 'multi':
                $this->centerObject=\App\Baricenter::find($data['objectId']);
                break;

        }

    }

    protected function checkPlanets()
    {
        $number=$this->centerObject->planets()->count();
        if($number>0){
            $planets=$this->centerObject->planets()->get();
            foreach($planets as $planet){
                $match=$this->checkPlanet($planet);
                if(!$match) continue;
                else {
                    $this->result=false;
                }
            }
        }
    }

    protected function checkPlanet($planet)
    {
        if($planet->distance==$this->data['distance']) {
            if ($planet->mark==$this->data['mark']){
                if ($this->data['mark']=='sin') return true;
                return ($this->countNumbers());
            }
            if($this->data['mark']=='sat') return false;
        }
        return false;
    }

    protected function countNumbers(){
        $number=$this->centerObject->planets()
            ->whereBetween('distance', [$this->data['distance']*0.95, $this->data['distance']*1.05])
            ->where('mark', $this->data['mark'])
            ->count();

        switch($this->data['mark']) {
            case 'bin':
                if($number>1) return true;
                break;
            case 'tri':
                if($number>2) return true;
                break;
            case 'qua':
                if($number>3) return true;
        }
        return false;
    }

    /**
     * @return \Illuminate\Support\Collection|null|static
     */
    public function getCenterObject()
    {
        return $this->centerObject;
    }

    /**
     * @return mixed
     */
    public function getSmartCheckMessage()
    {
        return $this->smartCheckMessage;
    }

    /**
     * @param mixed $smartCheckMessage
     */
    public function setSmartCheckMessage($smartCheckMessage)
    {
        $this->smartCheckMessage = $smartCheckMessage;
    }
}