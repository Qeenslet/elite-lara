<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 23.08.2015
 * Time: 17:48
 */

namespace App\Myclasses\localLetters;


class adminMail extends internalLetter {
    public function __construct($letter) {
        parent::__construct($letter);
    }
    protected function defineSender()
    {
        \App\User::find(1)->hasSent()->save($this->carta);
    }
}