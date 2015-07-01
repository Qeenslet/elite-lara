<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 21.06.2015
 * Time: 15:42
 */

namespace App\Myclasses;


use Carbon\Carbon;

class Charter {
    protected $chart;

    protected function __construct($type, $data=null){
       if(!$this->checkStamp($type, $data)){

            switch($type){
                case 1:
                    $charter=new \App\Myclasses\charterOne($data);
                    break;
                case 2:
                    $charter=new \App\Myclasses\charterTwo($data);
                    break;
                case 3:
                    $charter=new \App\Myclasses\charterThree($data);
                    break;
                case 0:
                    $charter=new \App\Myclasses\charterZero($data);
                    break;
            }
            $this->saveCache($type, $data, $charter);
            $this->chart=$charter;
        }
    }
    public static function draw($type, $data=null){
        $result=new self($type, $data);
        return $result->chart;
    }

    protected function checkStamp($style, $data){
        switch($style) {
            case 1:
                $search = \App\Firstcache::where('star', $data['star'])
                    ->where('size', $data['size'])
                    ->where('class', $data['class'])
                    ->where('planet', $data['planet'])
                    ->where('step', $data['step'])
                    ->first();
                break;
            case 2:
                $search=\App\Secondcache::where('style', $data['style'])
                    ->first();
                break;
            case 3:
                $search=\App\Thirdcache::where('star', $data['star'])
                    ->where('size', $data['size'])
                    ->where('class', $data['class'])
                    ->first();
                break;
            case 0:
                $search=\App\Zerocache::where('id', '>', 0)->first();
                break;
        }
        if($search){
            $created=new Carbon($search->created_at);
            $now=Carbon::now();
            if($created->diffInMinutes($now)>60){
                $search->delete();
                return false;
            }
            $this->chart=unserialize($search->data);
            return true;
        }
        return false;
    }

    protected function saveCache($style, $data, $charter){
        $data['data']=serialize($charter);
        switch ($style){
            case 1:
                \App\Firstcache::create($data);
                break;
            case 2:
                \App\Secondcache::create($data);
                break;
            case 3:
                \App\Thirdcache::create($data);
                break;
            case 0:
                \App\Zerocache::create($data);
                break;
        }
    }
}