<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 07.07.2015
 * Time: 19:56
 */

namespace App\Myclasses\search;


class searchSystem extends SearchEngine{
    private $id;

    private $string;
    private $array;
    private $n;
    protected $result;

    public function __construct($data)
    {
        $this->data=$data;
        $this->string=trim(str_replace('  ', ' ', $this->data['address']));
        $this->array = explode(' ', $this->string);
        $this->n = count($this->array);
        if($this->n>1) $this->manage();
    }
    private function manage()
    {
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
            default:
                $this->result=$result->get();
                $single=($this->matchRegion());
                if (!$single) return false;
                else return $single;
        }
    }
    private function matchRegion()
    {
        foreach($this->result as $one){
          if($this->checkRegion($one->region->name)) return $one;
           else continue;
       }
        return false;
    }

    private function checkRegion($name)
    {
        if($name == 'SPECIAL') return true;
        $result=stristr($this->string, $name);
        if(!$result) return false;
        else return true;
    }

    public function getIdsArray()
    {
        return [$this->id];
    }

}