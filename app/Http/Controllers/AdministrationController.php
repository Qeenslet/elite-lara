<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Golonka\BBCode\BBCodeParser;

class AdministrationController extends Controller {

    public function __construct(){
        $this->middleware('admin');
    }

    public function index(){
        $forModeration=\App\Moderation::all();
        $status=\App\Myclasses\Arrays::moderationMarks();
        return view('administration.moderation', compact('forModeration', 'status'));
    }

    public function delprove(Request $request){
        $todo=$request->all();
        switch($todo['action']){
            case 'delete':
                $aim=\App\Moderation::find($todo['target']);
                $aim->delete();
                return redirect('/administration');
            case 'approve':
                $aim=\App\Moderation::find($todo['target']);
                $data=unserialize($aim->data);
                $save=\App\Myclasses\dbSaver::save($data);
                if ($save) $aim->delete();

                return redirect('/administration');
        }
    }

    public function request(Request $request){
        $data=$request->all();
        $signature=\Auth::user()->name;
        $aim=\App\Moderation::find($data['target']);
        $letter['reciever']=$aim->user_id;
        $name=\App\User::find($aim->user_id)->name;
        $letter['header']="Запрос на дополнительные данные по системе $aim->address";
        $letter['body']="Добрый день, CMDR $name! К сожалению, нам недостаточно данных для одобрения добавленной вами планеты в системе $aim->address.
            Пришлите, если это возможно, скриншот карты системы. Для его включения в письмо можете воспользоваться любым сервисом хранения загруженных фотографий.
            С уважением, администратор $signature.";

        $carta=new \App\Letter($letter);
        \Auth::user()->hasSent()->save($carta);
        $aim->request='sent';
        $aim->save();
        return redirect('/administration');
    }

    public function mail(Request $request){
        $letterId=$request->input('letter');
        if(isset($letterId)){
            $letter=\App\Letter::find($letterId);
            if ($letter) {
                if ($letter->reciever == 1) {
                    $letter->status='read';
                    $letter->save();
                    return view('administration.singleLetter', compact('letter'));
                }
                elseif ($letter->sender == 1) {
                    return view('administration.singleLetter', compact('letter'));
                }
                return redirect('/administration/mail');
            }
            else return redirect('/administration/mail');
        }
        else {
            return view('administration.adminmail');
        }
    }

    public function sender(Requests\LetterFilter $request){
        $mess=$request->except('_token');
        $filteredMess=array_map(function($a){
            $a=str_replace(['<script>', 'javascript'],['<scrept>', 'jаvаscript'], $a);
            return $a;
        }, $mess);
        $bbcode = new BBCodeParser;
        $filteredMess['body']=$bbcode->parse($filteredMess['body']);
        $pilot=\App\User::find($filteredMess['reciever']);
        if(!$pilot){
            $pilot=\App\User::where('name', $filteredMess['reciever'])->first();
            $filteredMess['reciever']=$pilot->id;
        }

        $letter=new \App\Letter($filteredMess);
        \App\User::find(1)->hasSent()->save($letter);
        return redirect('/administration/mail');

    }

    public function mailDelete(Request $request){
        $id=$request->input('id');
        $letter=\App\Letter::find($id);
        if($letter->sender==1){
            $letter->show_sender='false';

        }
        else {
            $letter->show_reciever='false';
        }
        $letter->save();
        if($letter->show_sender=='false' && $letter->show_reciever=='false') {
            $letter->delete();
        }
        return redirect(route('adminmail'));
    }

    public function search(Requests\SearchRequest $request){
        $selRep=session('result');
        $searchData=$request->only('address');
        $regions=\App\Region::all();
        $nothing = 'nothing has been found';
        if($searchData['address']!=NULL) {
            $search=new \App\Myclasses\searchSystem($searchData['address']);
            if(!$search->id){
                return view('administration.search', compact('regions', 'nothing', 'searchData'));
            }
             else {
                 $systemD=new \App\Myclasses\starSystemInfo($search->id);
                 return view('administration.search', compact('regions', 'systemD', 'searchData'));
             }
        }
        return view('administration.search', compact('regions', 'selRep'));
    }

    public function delete(Request $request){
        $target=$request->only('target');
        \DB::beginTransaction();
        try {
            $address = \App\Address::find($target['target']);
            $stars = $address->stars()->get();
            foreach ($stars as $star) {
                $planets = $star->planets()->get();
                foreach ($planets as $planet) {
                    $planet->delete();
                }
                $star->delete();
            }
            $findings = $address->discoveries()->get();
            foreach ($findings as $one) {
                $one->delete();
            }
            $address->delete();
            \DB::commit();
            return redirect(route('search'))->with('result', 'Система успешно удалена');
        }
        catch(\PDOException $e){
            \DB::rollback();
            return redirect(route('search'))->with('result', 'Возникла ошибка удаления');
        }
    }
}
