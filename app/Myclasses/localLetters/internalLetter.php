<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 23.08.2015
 * Time: 17:43
 */

namespace App\Myclasses\localLetters;


abstract class internalLetter {
    protected $letter;

    protected $carta;

    public function __construct($letter)
    {
        $this->letter=$letter;
    }

    abstract protected function defineSender();

    public function send()
    {
        $this->carta=new \App\Letter($this->letter);
        $this->defineSender();
    }
}