<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 27.08.2015
 * Time: 9:59
 */

namespace App\Myclasses\Savers;


class addrSaver extends \App\Myclasses\Savers\Saver{

    private $newRegion;

    public function __construct(\App\Myclasses\Checks\checkAddr $checker)
    {
        parent::__construct($checker);
        $this->newRegion=0;
        $this->region=$this->checker->getRegion();
        try {
            $this->saveRegion();
            $this->finalize();
        }
        catch (\PDOException $e){
            $this->rollback();
        }

    }

    /**
     * saves region into DB if it is not already in there
     */
    protected function saveRegion()
    {
        if(!$this->region)
        {
            $this->region = \App\Region::create(['name' => $this->data['region']]);
            $this->newRegion=1;
        }
        $this->saveAddress();
    }

    protected function saveAddress()
    {
        $address = \App\Address::create(['name' => $this->data['address'],
            'region_id' => $this->region->id]);
        $this->addrId = $address->id;
        $this->address=$address;
    }
    protected function finalize()
    {
        $this->saveInsides();
        $this->saveStats();
        $this->commit();
    }

    protected function saveStats()
    {
        parent::saveStats();
        if($this->newRegion==1)
        {
            $this->statistics->latest_regions+=1;
            $this->statistics->regions+=1;
        }
        $this->statistics->latest_addresses+=1;
        $this->statistics->addresses+=1;
        $this->statistics->save();
    }
}