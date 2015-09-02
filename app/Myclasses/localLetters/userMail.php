<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 23.08.2015
 * Time: 17:55
 */

namespace App\Myclasses\localLetters;


use Auth;

class userMail extends internalLetter{

    public function __construct($letter)
    {
        parent::__construct($letter);
    }

    protected function defineSender()
    {
        Auth::user()->hasSent()->save($this->carta);
    }
}