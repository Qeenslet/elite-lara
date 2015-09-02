<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 09.08.2015
 * Time: 6:29
 */

namespace App\Myclasses\charters;


class charterModer {
    protected $query;


    public function __construct()
    {
        $this->query=\App\Statcache::Week()->get();
        \Carbon\Carbon::setToStringFormat('d/m/Y');

    }

    protected function getMe($smth)
    {
        $array=[];
        foreach ($this->query as $one) {
            $date=$one->created_at->__toString();
            switch ($smth) {
                case 'growth':
                    $total=$one->latest_stars+$one->latest_planets;
                    break;
                case 'total':
                    $total=$one->planets;
                    break;
                case 'stars':
                    $total=$one->latest_stars;
                    break;
                case 'planets':
                    $total=$one->latest_planets;
                    break;
                case 'regions':
                    $total=$one->latest_regions;
                    break;
                case 'addresses':
                    $total=$one->latest_addresses;
                    break;
                case 'tf':
                    $total=$one->tf;
                    break;
            }
            $array[$date]=$total;

        }
        return $array;
    }

    public function getGrowth()
    {
        return $this->getMe('growth');
    }

    public function getTotal()
    {
        return $this->getMe('total');
    }

    public function getStars()
    {
        return $this->getMe('stars');
    }

    public function getPlanets()
    {
        return $this->getMe('planets');
    }
    public function getRegions()
    {
        return $this->getMe('regions');
    }
    public function getAddresses()
    {
        return $this->getMe('addresses');
    }
    public function getTf()
    {
        return $this->getMe('tf');
    }

    public function __destruct()
    {
        \Carbon\Carbon::resetToStringFormat();
    }

}