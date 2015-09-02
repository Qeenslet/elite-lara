<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 28.08.2015
 * Time: 8:32
 */

namespace App\Myclasses\Insides;


class Insider {

    private $centers;
    private $name;
    private $regionId;
    private $addressId;

    public function __construct(\App\Address $address)
    {
        $this->addressId=$address->id;
        $this->regionId=$address->region->id;
        $this->name=$address->region->name." ".$address->name;

        if($address->stars()->count()>0) {
            foreach ($address->stars()->get() as $star) {
                $this->centers[] = new centerStar($star->id);
            }
        }
        if($address->centers()->count()>0) {
            foreach ($address->centers()->get() as $center) {
                $this->centers[] = new centerMulti($center->id);
            }
        }
    }
    /**
     * @return mixed
     */
    public function getCenters()
    {
        return $this->centers;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getRegionId()
    {
        return $this->regionId;
    }

    /**
     * @return mixed
     */
    public function getAddressId()
    {
        return $this->addressId;
    }
}