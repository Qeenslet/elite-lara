<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 01.09.2015
 * Time: 12:34
 */

namespace App\Myclasses\Savers;


class multiSaver extends Saver{

    protected $center;

    public function __construct(\App\Myclasses\Checks\checkMulti $checker)
    {
        parent::__construct($checker);
        $this->address=$checker->getAddress();
        $this->addrId=$this->address->id;

        try {
            $this->saveCenter();

            $this->finalize();
        }
        catch (\PDOException $e){
            $this->rollback();
        }
    }

    protected function saveCenter()
    {
        $array=['address_id'=>$this->data['address']];
        $this->center=\App\Baricenter::create($array);
        $this->addStars();
    }

    protected function addStars()
    {
        foreach($this->data['stars'] as $star)
        {
            $this->center->stars()->attach($star);
        }
    }

    protected function finalize()
    {
        $this->saveInsides();
        $this->commit();
    }
}