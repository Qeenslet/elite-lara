<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Moderation;
use App\Myclasses\Arrays;
use App\Myclasses\charters\Charter;
use Auth;
use Illuminate\Http\Request;

class AjaxController extends Controller {

    protected $localeDir;

    public function __construct()
    {
        switch(\App::getLocale())
        {
            case 'ru':
                $this->localeDir = 'ru.';
                break;
            default:
                $this->localeDir = '';
        }
    }

    public function chartBuilder(Request $request)
    {
        $data=$request->all();
        $colors=Arrays::colorList();
        if (isset($data['planet'])){
            switch($data['star']){
                case 15:
                case 16:
                    $data['size']=$data['class']=100;
                    break;
            }
            $chart = Charter::draw(1, $data);

            if($chart->anything==0) {
                return \App\Myclasses\Response::noData();
            }
            else {
                if ($chart->charType == 1) {
                    return view($this->localeDir.'charts.first', compact('chart', 'colors'));
                } else {
                    return view($this->localeDir.'charts.firstB', compact('chart', 'colors'));
                }
            }
        }
        if (isset($data['style'])){
            $chart = Charter::draw(2, $data);

            return view($this->localeDir.'charts.numtwo', compact('chart', 'colors'));
        }
        if (isset($data['sizeOrb'])){
            $newData['size']=$data['sizeOrb'];
            $newData['star']=$data['starOrb'];
            $newData['class']=$data['classOrb'];
            switch($newData['star']){
                case 15:
                case 16:
                    $newData['size']=$newData['class']=999;
                    break;
            }
            $chart=Charter::draw(3, $newData);

            if(!$chart->result) {
                return \App\Myclasses\Response::noData();
            }

            return view($this->localeDir.'charts.numthree', compact('chart', 'colors'));
        }
    }

    public function moderation(Request $request)
    {
        $target=Moderation::find($request->input('target'));
        $systemData=unserialize($target->data);

        $dataArray=$systemData->getData();
        $star=$systemData->getCenterObject();

        $messageE=$systemData->getSmartCheckMessage();
        $messageObj=unserialize($messageE['full']);
        $explanation=$messageObj->getMessage();

        $pNames=Arrays::planetsForCabinet();

        $systemInfo=new \App\Myclasses\Insides\Converter($dataArray['address']);

        switch($star->star) {
            case 3:
                $step=0.1;
                $stepKey=2;
                break;
            case 4:
                $step=0.05;
                $stepKey=1;
                break;
            case 0:
            case 5:
            case 14:
            case 15:
                $step=2;
                $stepKey=6;
                break;
            default:
                $step=1;
                $stepKey=5;
        }
        $starName=Arrays::nameStar($star);
        $fullName=$starName." ".
            $pNames[$dataArray['planet']]." ".$dataArray['distance']." ".$dataArray['mark'];
        $chartData="star=".$star->star."&class=".$star->class."&size=".$star->size;
        return view($this->localeDir.'administration.systemExtension', compact('target', 'systemInfo', 'explanation', 'fullName', 'chartData', 'step', 'stepKey'));
    }

    public function moderationCharts(Request $request)
    {
        $data=$request->all();
        $colors=Arrays::colorList();
        if (isset($data['step'])){
            $data['planet']=543210;
            $chart = Charter::draw(1, $data);
            if($chart->anything==0) {
                return \App\Myclasses\Response::noData();
            }
            else {
                return view($this->localeDir.'charts.firstModeration', compact('chart', 'colors'));
            }

        }
        else{
            $chart=Charter::draw(3, $data);
            if(!$chart->result) {
                return \App\Myclasses\Response::noData();
            }

            return view($this->localeDir.'charts.threeModer', compact('chart', 'colors'));
        }
    }

    public function cabinetInfo(Request $request)
    {
        $data=$request->except('_token');
        $info=new \App\Myclasses\Insides\ConverterForUser($data['address'], $data['user']);
        return view($this->localeDir.'cabinet.systemExtension', compact('info'));

    }

    public function showStats(Request $request)
    {
        $latest=\App\Myclasses\Counter::todayStats();
        return view($this->localeDir.'interface.dbStat', compact('latest'));
    }

    public function adminSearch(Request $request)
    {
       $data=$request->except('_token');
       return view($this->localeDir.'administration.objectData', compact('data'));

    }

    public function regionSearch(Request $request)
    {
        $string = $request->input('string');
        $regions = \App\Region::where('name', 'LIKE', $string.'%')->get();
        return view('responses.regions', compact('regions'));
    }
}
