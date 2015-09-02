<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Golonka\BBCode\BBCodeParser;

class AdministrationController extends Controller {

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $forModeration=\App\Moderation::all();
        $status=\App\Myclasses\Arrays::moderationMarks();
        return view('administration.moderation', compact('forModeration', 'status'));
    }

    public function delprove(Request $request)
    {
        $todo=$request->all();
        switch($todo['action']){
            case 'delete':
                $aim=\App\Moderation::find($todo['target']);
                $reciever=$aim->user_id;
                $addr=$aim->address;
                $decision='внесенные вами данные не были одобрены администратором';
                $aim->delete();
                break;
            case 'approve':
                $aim=\App\Moderation::find($todo['target']);
                $reciever=$aim->user_id;
                $addr=$aim->address;
                $decision='внесенные вами данные были одобрены и добавлены в базу';
                $data=unserialize($aim->data);
                $save=new \App\Myclasses\Savers\planetSaver($data);
                if ($save->getMessage()=='ok')
                    $aim->delete();
                break;
        }
        $letter=\App\Myclasses\Arrays::moderationLetter($addr, $decision, $reciever);
        $myMessage=new \App\Myclasses\localLetters\adminMail($letter);
        $myMessage->send();
        return redirect('/administration');
    }

    public function request(Request $request)
    {
        $data=$request->all();
        $signature=\Auth::user()->name;
        $aim=\App\Moderation::find($data['target']);
        $letter=\App\Myclasses\Arrays::moreInfoLetter($aim);
        $myMessage=new \App\Myclasses\localLetters\adminMail($letter);
        $myMessage->send();
        $aim->request='sent';
        $aim->save();
        return redirect('/administration');
    }

    public function mail(Request $request)
    {
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

    public function sender(Request $request)
    {
        $mess=$request->except('_token');
        if(isset($mess['recievers']))$addresses=$mess['recievers'];
        $filteredMess=array_map(function($a){
            $a=str_replace(['<script>', 'javascript'],['<scrept>', 'jаvаscript'], $a);
            return $a;
        }, $mess);
        $bbcode = new BBCodeParser;
        $filteredMess['body']=$bbcode->parse($filteredMess['body']);
        if(isset($filteredMess['reciever'])) {
            $myMessage=new \App\Myclasses\localLetters\adminMail($filteredMess);
            $myMessage->send();
        }
        else{
            foreach($addresses as $one) {
                $pilot = \App\User::where('name', $one)->first();
                $filteredMess['reciever'] = $pilot->id;
                $myMessage=new \App\Myclasses\localLetters\adminMail($filteredMess);
                $myMessage->send();
            }
        }
        return redirect('/administration/mail');

    }

    public function mailDelete(Request $request)
    {
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

    public function search(Requests\SearchRequest $request)
    {
        $selRep=session('result');
        $searchData=$request->all();
        $regions=\App\Region::all();
        $nothing = 'nothing has been found';
        if($searchData) {
            $searching = new \App\Myclasses\search\SearchEngine($searchData);
            $systemDs = $searching->getResult();
            if ($systemDs) {
                return view('administration.search', compact('regions', 'systemDs', 'searchData', 'selRep'));
            } else {
                return view('administration.search', compact('regions', 'nothing', 'searchData'));
            }
        }
        return view('administration.search', compact('regions', 'selRep'));
    }

    public function delete(Request $request)
    {
        $target=$request->only('target');
        if(!\Auth::user()->isModerator()) return redirect(route('search'))->with('result', 'У вас нет прав на удаление объектов');
        if(\App\Myclasses\Insides\Terminator::deleteAddress($target))return redirect(route('search'))->with('result', 'Система успешно удалена');
        else return redirect(route('search'))->with('result', 'Возникла ошибка удаления');

    }
    public function cambiar(Request $request)
    {
        $style=$request->input('action');
        $object=$request->input('type');
        $data=$request->except('action', 'type', '_token');
        switch($style){
            case 'change':
                $result=new \App\Myclasses\Savers\Rewriter($object, $data);
                break;
            case 'delete':
                if(!\Auth::user()->isModerator())
                {
                    return back()->with('result', 'У вас нет прав на удаление объектов');
                }
                $result=new \App\Myclasses\Savers\Deleter($object, $data);
                break;
        }
        switch($result->getMessage())
        {
            case 'ok':
                $response='Данные были изменены!';
                break;
            case 'fail':
                $response='Произошел сбой при изменении';
        }

        return back()->with('result', $response);
    }
}
