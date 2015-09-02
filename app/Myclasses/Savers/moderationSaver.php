<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 02.09.2015
 * Time: 7:55
 */

namespace App\Myclasses\Savers;


class moderationSaver extends Saver {

    protected $user;
    protected $status;

    public function __construct(\App\Myclasses\Checks\checkPlanet $checker)
    {
        parent::__construct($checker);
        $this->address=$checker->getAddress();
        $this->addrId=$this->address->id;
        $this->user=\Auth::user();

        //remembering the user who made a discovery
        $this->checker->setUserData($this->user->id);
        $status=$this->checker->getSmartCheckMessage();
        $this->status=$status['type'];
        $this->saveIt();
        $this->finalize();

    }

    protected function saveIt()
    {
        $address=$this->address->region->name." ".$this->address->name;
        $data=serialize($this->checker);
        $array=['type'=>$this->status,
                'user_id'=>$this->user->id,
                'data'=>$data,
                'address'=>$address];
        \App\Moderation::create($array);
    }

    protected function finalize()
    {
        $this->commit();
        $this->message='moder';
    }
}