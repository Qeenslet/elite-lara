<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 07.07.2015
 * Time: 19:56
 */

namespace App\Myclasses;


class searchSystem {
    public $id;

    private $string;
    private $array;
    private $n;
    private $result;

    public function __construct($string){
        $this->string=trim(str_replace('  ', ' ', $string));
        $this->array = explode(' ', $string);
        $this->n = count($this->array);
        $this->manage();
    }
    private function manage(){
        $attempt=$this->tryString($this->array[$this->n - 1]);
        if(!$attempt) {
            $attempt = $this->tryString($this->array[$this->n - 2] . " " . $this->array[$this->n - 1]);
            if (!$attempt) {
                if ($this->n > 3) {
                    $attempt = $this->tryString($this->array[$this->n - 3] . " " . $this->array[$this->n - 2] . " " . $this->array[$this->n - 1]);
                    if ($attempt) {
                        $this->id = $attempt->id;
                    }
                }
            } else {
                $this->id = $attempt->id;
            }
        }
        else {
            $this->id = $attempt->id;
        }
    }
    private function tryString($string)
    {
        $result=\App\Address::search($string);
        $number = $result->count();

        switch($number){
            case 0:
                return false;
            case 1:
                return $result->first();
            default:
                $this->result=$result->get();
                $single=($this->matchRegion());
                if (!$single) return false;
                else return $single;
        }
    }
    private function matchRegion(){
        foreach($this->result as $one){
          if($this->checkRegion($one->region->name)) return $one;
           else continue;
       }
        return false;
    }

    private function checkRegion($name){
        $result=stristr($this->string, $name);
        if(!$result) return false;
        else return true;
    }

}