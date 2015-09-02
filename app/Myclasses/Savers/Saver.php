<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 27.08.2015
 * Time: 9:52
 */

namespace App\Myclasses\Savers;


class Saver {
    protected $checker;
    protected $data;
    protected $fail;

    protected $address;
    protected $user;

    protected $region;
    protected $addrId;
    protected $starId;

    protected $statistics;
    protected $userInstance;

    protected $message;

    public function __construct(\App\Myclasses\Checks\Checker $checker)
    {
        \DB::beginTransaction();
        $this->fail=0;
        $this->checker = $checker;
        $this->data=$this->checker->getData();

    }
    /**
     * @return mixed
     */
    public function getAddrId()
    {
        return $this->addrId;
    }

    protected function saveInsides()
    {
        $data = new \App\Myclasses\Insides\Insider($this->address);
        $inside=$this->address->inside()->first();
        if(!$inside) {
            $sData=serialize($data);
            $save=\App\Inside::create(['address_id'=>$this->addrId, 'data'=>$sData]);
        }
        else
        {
           $inside->data=serialize($data);
           $inside->save();
        }

    }

    protected function saveStats()
    {
        $today=\Carbon\Carbon::today();
        $now=\Carbon\Carbon::now();
        $this->statistics=\App\Statcache::whereBetween('created_at', [$today, $now])->first();
    }

    protected function savePoints()
    {
        $this->userInstance = \App\User::find($this->user);
        $this->saveFindings();
    }

    protected function saveFindings()
    {
        $findings=$this->userInstance->findings()->where('address_id', $this->addrId)->first();
        if(!$findings){
            $findingSave= new \App\Finding(['address_id'=>$this->addrId]);
            $this->userInstance->findings()->save($findingSave);
        }
    }

    protected function rollback()
    {
        \DB::rollback();
        $this->fail=1;
        $this->message='fail';
    }

    protected function commit()
    {
        if($this->fail!=1)\DB::commit();
        $this->message='ok';
    }

    public function getMessage()
    {
        return $this->message;
    }

}