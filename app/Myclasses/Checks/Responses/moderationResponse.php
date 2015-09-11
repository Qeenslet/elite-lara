<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 08.09.2015
 * Time: 6:14
 */

namespace App\Myclasses\Checks\Responses;


abstract class moderationResponse {

    protected $locale;

    public function __construct()
    {
        $this->locale=\App::getLocale();
    }

    abstract function getMessage();

    protected function checkLocale()
    {
        $locale=\App::getLocale();
        if($this->locale!=$locale) $this->locale=$locale;
    }
}