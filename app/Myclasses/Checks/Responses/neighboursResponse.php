<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 08.09.2015
 * Time: 7:02
 */

namespace App\Myclasses\Checks\Responses;


class neighboursResponse extends moderationResponse{

    protected $total;
    protected $step;
    protected $number;
    protected $percentage;

    public function __construct(Array $array)
    {
        parent::__construct();
        $this->total=$array['total'];
        $this->step=$array['step'];
        $this->number=$array['number'];
        $this->percentage=$array['percentage'];
    }
    function getMessage()
    {
        $this->checkLocale();
        if ($this->locale=='en')return $this->giveEnglish();
        return $this->giveRussian();
    }

    protected function giveRussian()
    {
        return $this->number.' планет на '.($this->step*2).' а.е. в округе из '.$this->total.' для данного типа звезд, что составляет '.$this->percentage.'%';
    }

    protected function giveEnglish()
    {
        return "Not sufficient ($this->percentage %) number  of neighbourhood planets: $this->number in ".($this->step*2)." AU of $this->total planets in total.";
    }
}