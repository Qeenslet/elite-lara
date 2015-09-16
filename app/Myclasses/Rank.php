<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 29.06.2015
 * Time: 7:58
 */

namespace App\Myclasses;


class Rank {
    public $logo;
    public $rank;
    public $progression;
    public $stars;
    public $planets;
    public $scores;

    private static $instance;
    private $user;
    private $rankNumber;

    private function __construct()
    {
        $this->user=\Auth::user();
        if(!$this->user->points){
            ($this->user->id==1)?$this->rank='Ghost of Christmas Past':$this->rank='Не определен';
            ($this->user->id==1)?$this->progression=100:$this->progression=0;
            ($this->user->id==1)?$this->logo='Elite.png':$this->logo='Aimless.png';
            $this->scores=$this->stars=$this->planets=0;
        }
        else {
            $this->scores = $this->user->points->points;
            $this->stars = $this->user->points->stars;
            $this->planets = $this->user->points->planets;
            $this->countRank();
        }
    }

    public static function getRank()
    {
        if (self::$instance==NULL) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function countRank()
    {
        if($this->scores<54) {
            $this->rankNumber=0;
            $this->countProgression(0, 54);
        }
        elseif ($this->scores>=54 && $this->scores<109) {
            $this->rankNumber=1;
            $this->countProgression(54, 109);
        }
        elseif ($this->scores>=109 && $this->scores<218) {
            $this->rankNumber=2;
            $this->countProgression(109, 218);
        }
        elseif ($this->scores>=218 && $this->scores<438) {
            $this->rankNumber=3;
            $this->countProgression(218, 438);
        }
        elseif ($this->scores>=438 && $this->scores<875) {
            $this->rankNumber=4;
            $this->countProgression(438, 875);
        }
        elseif ($this->scores>=875 && $this->scores<1750) {
            $this->rankNumber=5;
            $this->countProgression(875, 1750);
        }
        elseif ($this->scores>=1750 && $this->scores<2500) {
            $this->rankNumber=6;
            $this->countProgression(1750, 2500);
        }
        elseif ($this->scores>=2500 && $this->scores<5000) {
            $this->rankNumber=7;
            $this->countProgression(2500, 5000);
        }
        elseif ($this->scores>5000) {
            $this->rank=8;
            $this->progression=100;
        }
        $this->fillTheRest();
    }
    private function fillTheRest()
    {
        $logos=\App\Myclasses\Arrays::rankLogo();
        $ranks=\App\Myclasses\Arrays::rankList();
        $this->logo=$logos[$this->rankNumber];
        $this->rank=$ranks[$this->rankNumber];
    }

    private function countProgression($low, $high)
    {
        $this->progression=round(($this->scores-$low)/($high - $low)*100, 2);
    }
}