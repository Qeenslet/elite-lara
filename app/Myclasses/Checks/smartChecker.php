<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 31.08.2015
 * Time: 10:44
 */

namespace App\Myclasses\Checks;


class smartChecker {

    const BARY=1;
    const NORMAL=2;
    const MODER=3;

    const UPPER_LIMIT=1.1;
    const LOWER_LIMIT=0.9;

    private $checkResult;
    private $centerObject;
    private $counter;

    private $star;
    private $class;
    private $size;
    private $planets;
    private $distance;

    private $maxDistance;
    private $minDistance;

    private $decision;

    public static function check(checkPlanet $planet)
    {
        $check=new self($planet);
       return $check->returnSaver();
    }

    private function __construct(checkPlanet $planet)
    {
        $this->checkResult=$planet;
        $this->centerObject=$this->checkResult->getCenterObject();
        if($this->centerObject instanceof \App\Baricenter) $this->decision=self::BARY;
        else {
            $this->counter = new \App\Myclasses\Counter();
            $this->data=$this->checkResult->getData();
            $this->extractData();
            $this->firstCheck();
        }
    }

    private function  extractData()
    {
        $this->star=$this->centerObject->star;
        $this->class=$this->centerObject->class;
        $this->size=$this->centerObject->size;
        if ($this->data['planet']<4) $this->planets=[0,1,2,3];
        else $this->planets=[$this->data['planet']];
        $this->distance=$this->data['distance'];
    }

    private function firstCheck()
    {
        $this->defineLimits();
        if($this->distance < $this->maxDistance && $this->distance > $this->minDistance) $this->secondCheck();
        else
        {
            if ($this->distance > $this->maxDistance)
            {
                $differ['main'] = $this->distance - $this->maxDistance;
                $differ['sub']= 'high';
            }
            else
            {
                $differ['main'] = $this->minDistance - $this->distance;
                $differ['sub']= 'less';
            }
            $this->generateModerationReason(1, $differ);
        }

    }

    private function defineLimits()
    {
        $this->maxDistance = $this->counter->maxDistance([$this->star], [$this->size], $this->planets, [$this->class])*self::UPPER_LIMIT;
        $this->minDistance = $this->counter->minDistance([$this->star], [$this->size], $this->planets, [$this->class])*self::LOWER_LIMIT;
    }

    private function secondCheck()
    {
        $step = $this->maxDistance / 10;
        $low = $this->distance - $step;
        $high = $this->distance + $step;

        $total = $this->counter->countPlanets([$this->star], $this->planets, 100, [$this->size], [$this->class]);
        $number = $this->counter->countDiapason($low, $high, [$this->star], $this->planets, [$this->size], [$this->class]);

        $percentage = $number / $total * 100;

        if ($percentage < 10)
        {
            $differ['percentage']=$percentage;
            $differ['step']=$step;
            $differ['total']=$total;
            $differ['number']=$number;
            $this->generateModerationReason(2, $differ);
        }
        else
        {
            $this->decision=self::NORMAL;
        }
    }

    private function generateModerationReason($reason, $data)
    {
        $message=['type'=>'', 'full'=>''];
        switch ($reason)
        {
            case 1:
                $message['full']= serialize(new \App\Myclasses\Checks\Responses\excessResponse($data));
                $message['type']='danger';
                break;
            case 2:
                $message['full']=serialize(new \App\Myclasses\Checks\Responses\neighboursResponse($data));
                $message['type']='warning';
                break;
        }
        $this->checkResult->setSmartCheckMessage($message);
        $this->decision=self::MODER;
    }

    public function returnSaver()
    {
        switch($this->decision)
        {
            case self::BARY:
                return new \App\Myclasses\Savers\barySaver($this->checkResult);
                break;
            case self::NORMAL:
                //return normalSaver
                return new \App\Myclasses\Savers\planetSaver($this->checkResult);
                break;
            case self::MODER:
                //return ModerSaver
                return new \App\Myclasses\Savers\moderationSaver($this->checkResult);
                break;
        }
    }


}