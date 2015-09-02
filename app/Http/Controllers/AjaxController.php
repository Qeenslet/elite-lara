<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Moderation;
use App\Myclasses\Arrays;
use App\Myclasses\charters\Charter;
use Auth;
use Illuminate\Http\Request;

class AjaxController extends Controller {

	public function chartForms(Request $request)
    {
        $count = Arrays::allStarsArray();
        if(\Auth::check()){
            $userId=\Auth::user()->id;
        }
        $formStyle=$request->input('form');
        switch($formStyle){
            case 0:
                $charter=Charter::draw(0);
                $colors=Arrays::colorList();
                return view('charts.zero', compact('charter', 'colors'));
            case 1:
                return view('chartforms.one', compact('count'));
            case 2:
                return view('chartforms.two');
            case 3:
                return view('chartforms.three', compact('count'));
            case 4:
                $letters= Auth::user()->hasInbox()->where('show_reciever', 'true')->orderBy('id', 'desc')->get();
                return view('cabinet.inbox', compact('letters'));
            case 5:
                $letters= Auth::user()->hasSent()->where('show_sender', 'true')->orderBy('id', 'desc')->get();
                return view('cabinet.sent', compact('letters'));
            case 6:
                $users=\App\User::all();
                return view('cabinet.newmail', compact('users'));
            case 7:
                $letters= \App\User::find(1)->hasInbox()->where('show_reciever', 'true')->orderBy('id', 'desc')->get();
                return view('administration.inbox', compact('letters'));
            case 8:
                $letters= \App\User::find(1)->hasSent()->where('show_sender', 'true')->orderBy('id', 'desc')->get();
                return view('administration.sent', compact('letters'));
            case 9:
                $users=\App\User::all();
                return view('administration.newmail', compact('users'));

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
                return "<h3>По данному запросу в базе недостаточно данных</h3>";
            }
            else {
                if ($chart->charType == 1) {
                    return view('charts.first', compact('chart', 'colors'));
                } else {
                    return view('charts.firstB', compact('chart', 'colors'));
                }
            }
        }
        if (isset($data['style'])){
            $chart = Charter::draw(2, $data);

            return view('charts.numtwo', compact('chart', 'colors'));
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
                return "<h3>По данному типу звезд еще не собрано достаточно данных!</h3>h3>";
            }

            return view('charts.numthree', compact('chart', 'colors'));
        }
    }

    public function moderation(Request $request)
    {
        $target=Moderation::find($request->input('target'));
        $systemData=unserialize($target->data);

        $dataArray=$systemData->getData();
        $star=$systemData->getCenterObject();

        $messageE=$systemData->getSmartCheckMessage();
        $explanation=$messageE['full'];

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
        $fullName=$starName." Планета: ".
            $pNames[$dataArray['planet']]." ".$dataArray['distance']." а.е. ".$dataArray['mark'];
        $chartData="star=".$star->star."&class=".$star->class."&size=".$star->size;
        return view('administration.systemExtension', compact('target', 'systemInfo', 'explanation', 'fullName', 'chartData', 'step', 'stepKey'));
    }

    public function moderationCharts(Request $request)
    {
        $data=$request->all();
        $colors=Arrays::colorList();
        if (isset($data['step'])){
            $data['planet']=543210;
            $chart = Charter::draw(1, $data);
            if($chart->anything==0) {
                return "<h3>По данным типам звезд нет данных</h3>";
            }
            else {
                return view('charts.firstModeration', compact('chart', 'colors'));
            }

        }
        else{
            $chart=Charter::draw(3, $data);
            if(!$chart->result) {
                return "<h3>По данному типу звезд еще не собрано достаточно данных!</h3>";
            }

            return view('charts.threeModer', compact('chart', 'colors'));
        }
    }

    public function cabinetInfo(Request $request)
    {
        $data=$request->except('_token');
        $info=new \App\Myclasses\Insides\ConverterForUser($data['address'], $data['user']);
        return view('cabinet.systemExtension', compact('info'));

    }

    public function showStats(Request $request)
    {
        $latest=\App\Myclasses\Counter::todayStats();
        return view('interface.dbStat', compact('latest'));
    }

    public function adminSearch(Request $request)
    {
       $data=$request->except('_token');
       return view('administration.objectData', compact('data'));

    }
}
