<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 08.09.2015
 * Time: 6:18
 */

namespace App\Myclasses\Checks\Responses;


class excessResponse extends moderationResponse{

    protected $sub;
    protected $main;

    public function __construct(Array $array)
    {
        parent::__construct();
        $this->sub=$array['sub'];
        $this->main=$array['main'];

    }

    function getMessage()
    {
        $this->checkLocale();
        if ($this->locale=='en')return $this->giveEnglish();
        return $this->giveRussian();
    }

    protected function giveEnglish()
    {
        switch($this->sub)
        {
            case 'high':
                return 'Excesses the spreading area for the similar types of planets for '.$this->main.' AU';
            case 'less':
                return 'Is '.$this->main.'AU lower than the spreading area for the similar types of planets';
        }

    }

    protected function giveRussian()
    {
        switch($this->sub)
        {
            case 'high':
                return 'Превышает зону распределения для данного типа планета на '.$this->main.' а.е.';
            case 'less':
                return 'Меньше зоны распределения для данного типа планет на '.$this->main.' а.е.';
        }
    }
}