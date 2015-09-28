<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 26.09.2015
 * Time: 12:20
 */

namespace App\Myclasses\Insides;


class planetExtraInfo {

    public $common;
    public $composition;
    public $atmosphere;
    public $orbit;

    public function __construct(\Illuminate\Database\Eloquent\Model $extra)
    {
        $this->common = $extra->toArray();
        $this->composition = $extra->composition->toArray();
        $this->atmosphere = $extra->atmosphere->toArray();
        $this->orbit = $extra->orbit->toArray();
    }
}