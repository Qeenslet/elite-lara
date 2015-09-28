<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 23.09.2015
 * Time: 6:59
 */

namespace App\Myclasses\Savers;


class starExtraSaver extends extraSaver{

    private $star;
    private $extras;
    private $data;

    public function __construct(array $data)
    {
        parent::__construct();
        $this->data = $data;
        $this->star = \App\Star::find($data['star_id']);
        try {
            $this->defineAddress();
            $this->checkPresence();
            $this->savePoints();
        }
        catch (\PDOException $e){
            $this->rollback();
        }

    }

    private function checkPresence()
    {
        $this->extras = $this->star->starData()->first();
        if (! $this->extras)
            $this->saveNew();
        else
            $this->rewrite();
    }

    protected function defineAddress()
    {
        $this->address = $this->star->address;
    }

    protected function saveNew()
    {
        \App\Stardata::create($this->data);
        $this->first = 1;
    }

    protected function rewrite()
    {
        $this->extras->age = $this->data['age'];
        $this->extras->smass = $this->data['smass'];
        $this->extras->srad = $this->data['srad'];
        $this->extras->temperature = $this->data['temperature'];
        $this->extras->save();
    }
}