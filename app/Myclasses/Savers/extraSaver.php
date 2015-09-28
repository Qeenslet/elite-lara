<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 23.09.2015
 * Time: 6:54
 */

namespace App\Myclasses\Savers;


abstract class extraSaver {

    protected $first;
    protected $address;

    public function __construct()
    {
        $this->first = 0;
        \DB::beginTransaction();
    }

    abstract protected function defineAddress();

    abstract protected function saveNew();

    abstract protected function rewrite();

    protected function savePoints()
    {
        if ($this->first == 1)
        {
            $user = \Auth::user();
            $user->points()->increment('points', 5);
        }
        $this->updateInsides();
        \DB::commit();
    }

    protected function rollback()
    {
        \DB::rollback();
    }

    public function getAddrId()
    {
        return $this->address->id;
    }

    protected function updateInsides()
    {
        $newData=new \App\Myclasses\Insides\Insider($this->address);
        $this->address->inside->data=serialize($newData);
        $this->address->inside->save();
    }


}