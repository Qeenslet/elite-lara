<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 02.09.2015
 * Time: 14:46
 */

namespace App\Myclasses\Savers;


class Rewriter extends Saver {

    protected $toChange;
    protected $data;

    public function __construct($object, $data)
    {
        $this->data=$data;
        \DB::beginTransaction();
        try {
            switch ($object) {
                case 'star':
                    $this->toChange = \App\Star::find($data['id']);
                    $this->address = $this->toChange->address;
                    $this->changeStar();
                    $this->finalize();
                    break;
                case 'planet':
                    $this->toChange = \App\Planet::find($data['id']);
                    $this->address = $this->toChange->star->address;
                    $this->changePlanet();
                    $this->finalize();
                    break;
            }
        }
        catch (\PDOException $e){
            $this->rollback();
        }
    }

    protected function changeStar()
    {
        $this->toChange->star=$this->data['star'];
        $this->toChange->size=$this->data['size'];
        $this->toChange->class=$this->data['class'];
        $this->toChange->save();
    }

    protected function changePlanet()
    {
        $this->toChange->planet=$this->data['planet'];
        $this->toChange->distance=$this->data['distance'];
        $this->toChange->mark=$this->data['mark'];
        $this->toChange->save();
    }

    protected function finalize()
    {
        $this->saveInsides();
        $this->commit();
    }
}