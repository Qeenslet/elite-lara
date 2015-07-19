<?php
namespace App\Myclasses;
use App\Myclasses\Arrays;
use App\Planet;
use App\Star;
use Illuminate\Support\Facades\DB;

/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 21.06.2015
 * Time: 11:29
 */

class Counter {
    /*
     * Returns array with the statistics about all types of planets in database. Zero Chart
     * */
    public function ZeroChart(){
        $total=Planet::count();
        $planets=Arrays::planetTypeArray();
        for($i=0; $i<count($planets); $i++){
            $totalType=Planet::where('planet', $i)->count();
            $result[$planets[$i]]=$totalType/$total*100;
        }
        return $result;

    }
    /*
     * returns array with the number of planets of the defined type according to the step. 1st Charter
     * */
    public function queryDiapason($star, $planet, $step, $size=[0,1,2,3,4,5,6,7], $class=[0,1,2,3,4,5,6,7,8,9]){
        $maxDistance=$this->maxDistance($star, $size, $planet, $class);
        $lowest=0;
        $highest=$step;
        $result=[];
        for ($i=0; $i<$maxDistance; $i+=$step) {
            $result["$i"]=$this->countDiapason($lowest, $highest, $star, $planet, $size, $class);
            $lowest=$highest;
            $highest+=$step;
        }
        return $result;
    }
    protected function starsAndPlanets($star, $planets, $class, $size){
        return DB::table('stars')->join('planets', 'stars.id', '=', 'planets.star_id')
            ->where('stars.star', $star)
            ->whereIn('stars.size', $size)
            ->whereIn('stars.class', $class)
            ->whereIn('planets.planet', $planets);
    }
    /*
     * Counts the biggest distance for each type of star/planet type. 1st Charter
     * */
    public function maxDistance($star, $size, $planet, $class){
        $query=$this->starsAndPlanets($star, $planet, $class, $size);
        return $query->max('planets.distance');
    }

    public function minDistance($star, $size, $planet, $class){
        $query=$this->starsAndPlanets($star, $planet, $class, $size);
        return $query->min('planets.distance');
    }

    /*
     * Counts the number of planets of the selected type in the diapason. 1st Charter
     * */
    public function countDiapason($lowest, $highest, $star, $planet, $size, $class){
        $query=$this->starsAndPlanets($star, $planet, $class, $size);
        return $query->whereBetween('planets.distance', array($lowest, $highest))->count();
    }
    /*
     * Second chart service method
     * */
    public function planetSelect($planets){
        return DB::table('planets')
            ->whereIn('planet', $planets)
            ->count();
    }
    /*
     * Second chart service method
     * */
    public function starSelectExcluding($stars){
        return DB::table('stars')
            ->whereNotIn('star', $stars)
            ->distinct()
            ->lists('star');
    }
    /*
     * Second chart service method also is used in menus.
     * */
    public function starSelect($smth){
        return DB::table('stars')
            ->distinct()
            ->lists($smth);
    }
    /*
     * Second chart main method.
     * */

    public function countPlanets($star, $planets, $total, $size=[0,1,2,3,4,5,6,7], $class=[0,1,2,3,4,5,6,7,8,9]){
        $query=$this->starsAndPlanets($star, $planets, $class, $size);
        $amount=$query->count();
        return $amount/$total*100;
    }

    public function countRare($planets, $total){
        $amount=DB::table('stars')->join('planets', 'stars.id', '=', 'planets.star_id')
            ->where('stars.star', '>', 4)
            ->whereIn('planets.planet', $planets)
            ->count();
        return $amount/$total*100;
    }

    public function orbitCount($star, $size, $class, $planet){
        $query=$this->starsAndPlanets($star, $planet, $class, $size);
        return $query->lists('planets.distance');
    }

    public static function todayStats(){
        $today=\Carbon\Carbon::today();
        $now=\Carbon\Carbon::now();
        $statistics=\App\Statcache::whereBetween('created_at', [$today, $now])->first();
        if(!$statistics) {
            $planets=Planet::all()->count();
            $regions = \App\Region::all()->count();
            $addresses=\App\Address::all()->count();
            $tf=Planet::where('planet', '<', 4)->count();
            $statistics=\App\Statcache::create(['planets'=>$planets,
                'regions'=>$regions,
                'tf'=>$tf,
                'addresses'=>$addresses,
                'latest_stars'=>0,
                'latest_planets'=>0,
                'latest_regions'=>0,
                'latest_addresses'=>0]);
        }
        $stat['latest'] = $statistics->latest_stars+$statistics->latest_planets;
        $stat['total'] = $statistics->planets;
        $stat['sys'] = $statistics->addresses;
        $stat['tf'] = $statistics->tf;
        $stat['reg'] = $statistics->regions;
        return $stat;
    }

}