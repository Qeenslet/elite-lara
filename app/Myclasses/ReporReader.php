<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 01.07.2015
 * Time: 5:23
 */

namespace App\Myclasses;


class ReporReader {
    protected $pattern5_1 = '/^([A-Za-z-_0-9\']+) ([A-Z0-9]{2,5}) ([VI]+) (T_H-M|WW|E_L|T_WW|T_RW|AW) ?([0-9,.]+)$/';
    protected $pattern5_2 = '/^([A-Za-z-_0-9]+) ([A-Za-z-_0-9]+) (N|BH) (T_H-M|WW|E_L|T_WW|T_RW|AW) ?([0-9,.]+)$/';
    protected $pattern6 = '/^([A-Za-z-_0-9]+) ([A-Za-z-_0-9]+) ([A-Z0-9]{2,5}) ([VI]+) (T_H-M|WW|E_L|T_WW|T_RW|AW) ?([0-9,.]+)$/';
    protected $pattern6_1 = '/^([A-Za-z-_0-9]+) ([A-Za-z-_0-9]+) ([A-Z0-9]{1,2}) (T_H-M|WW|E_L|T_WW|T_RW|AW) (sin|bin|tri) ?([0-9,.]+)$/';
    protected $pattern7 = '/^([A-Za-z-_0-9]+) ([A-Za-z-_0-9]+) ([A-Z0-9]{2,5}) ([VI]+) (T_H-M|WW|E_L|T_WW|T_RW|AW) (sin|bin|tri) ?([0-9,.]+)$/';

    protected $string;
    protected $data;
    public $report; //1-ok; 2-moder; 3-can't read; 4-similar;

    protected function __construct($string){
        $string = trim($string);
        $string = str_replace(array("   ", "  ", ","), array(" ", " ", "."), $string);
        $this->string=$string;
        $this->data['one_name']='';

        switch(true){
            case preg_match($this->pattern5_1, $string, $array):

                $this->unique_region($array);
                break;
            case preg_match($this->pattern5_2, $string, $array):

                $this->fiver($array);
                break;
            case preg_match($this->pattern6, $string, $array):

                $this->sixer($array);
                break;
            case preg_match($this->pattern6_1, $string, $array):

                $this->sixer_a($array);
                break;
            case preg_match($this->pattern7, $string, $array):

                $this->sevener($array);
                break;
            default:
                $this->report = 3;
        }
        if(!$this->report) {
            $this->workOut();
        }
    }
    public static function analize($string){
        $analizer=new self($string);
        return $analizer->report;
    }

    protected function returnBreaks($string)
    {
        return strtoupper(str_replace('_', ' ', $string));
    }
    protected function star_type($string)
    {
        $string = str_replace(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), '', $string);
        $star_array = array('A' => 0, 'F' => 1, 'G' => 2, 'K' => 3, 'M' => 4, 'B' => 5, 'AeBe' => 6, 'CN' => 7, 'DA' => 8, 'MS' => 9, 'L' => 10, 'T' => 11, 'TTS' => 12, 'Y' => 13, 'W' => 14, 'N' => 15, 'BH' => 16);
        return $star_array[$string];
    }
    protected function star_size($string)
    {
        $size_array = array('0' => 0, 'I' => 1, 'II' => 2, 'III' => 3, 'IV' => 4, 'V' => 5, 'VI' => 6, 'VII' => 7);
        return $size_array[$string];
    }

    protected function temperature($string)
    {
        $a = strrev($string);
        return intval($a);
    }
    protected function planet_type($string)
    {
        $planet_array = array('T_H-M' => 0, 'T_WW' => 1, 'T_RW' => 2, 'E_L' => 3, 'WW' => 4, 'AW' => 5);

        return $planet_array[$string];
    }

    protected function unique_region($array){
        $this->data['region']='SPECIAL';
        $this->data['code_name']=$this->returnBreaks($array[1]);
        $this->data['star']=$this->star_type($array[2]);
        $this->data['size']=$this->star_size($array[3]);
        $this->data['class']=$this->temperature($array[2]);
        $this->data['planet']=$this->planet_type($array[4]);
        $this->data['distance']=$array[5];
        $this->data['mark']='sin';
    }

    protected function fiver(array $array)
    {
        $this->data['region']=$this->returnBreaks($array[1]);
        $this->data['code_name']=$this->returnBreaks($array[2]);
        $this->data['star']=$this->star_type($array[3]);
        $this->data['size']=0;
        $this->data['class']=0;
        $this->data['planet']=$this->planet_type($array[4]);
        $this->data['distance']=$array[5];
        $this->data['mark']='sin';
    }

    protected function sixer(array $array)
    {
        $this->data['region']=$this->returnBreaks($array[1]);
        $this->data['code_name']=$this->returnBreaks($array[2]);
        $this->data['star']=$this->star_type($array[3]);
        $this->data['size']=$this->star_size($array[4]);
        $this->data['class']=$this->temperature($array[3]);
        $this->data['planet']=$this->planet_type($array[5]);
        $this->data['distance']=$array[6];
        $this->data['mark']='sin';
    }
    protected function sevener(array $array)
    {
        $this->data['region']=$this->returnBreaks($array[1]);
        $this->data['code_name']=$this->returnBreaks($array[2]);
        $this->data['star']=$this->star_type($array[3]);
        $this->data['size']=$this->star_size($array[4]);
        $this->data['class']=$this->temperature($array[3]);
        $this->data['planet']=$this->planet_type($array[5]);
        $this->data['distance']=$array[7];
        $this->data['mark']=$array[6];
    }
    protected function sixer_a(array $array)
    {
        $this->data['region']=$this->returnBreaks($array[1]);
        $this->data['code_name']=$this->returnBreaks($array[2]);
        $this->data['star']=$this->star_type($array[3]);
        $this->data['size']=0;
        $this->data['class']=0;
        $this->data['planet']=$this->planet_type($array[4]);
        $this->data['distance']=$array[6];
        $this->data['mark']=$array[5];
    }

    protected function workOut(){
        $checkResult=\App\Myclasses\Checker::checkIt($this->data);
        if($checkResult->code==5) $this->report=4;
        else{
            if($checkResult->smartCode!=1){
                \App\Myclasses\moderationSaver::save($checkResult);
                $this->report=2;
            }
            else{
                \App\Myclasses\dbSaver::save($checkResult);
                $this->report=1;
            }
        }

    }
}