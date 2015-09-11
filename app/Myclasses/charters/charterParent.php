<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 04.09.2015
 * Time: 11:44
 */

namespace App\Myclasses\charters;


abstract class charterParent {

    public $locale;

    public function __construct()
    {
        $this->locale=\App::getLocale();
    }

    abstract function changeLocale($locale);
}