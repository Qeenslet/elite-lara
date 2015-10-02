<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Golonka\BBCode\BBCodeParser;

class AdministrationController extends Controller {

    protected $localeDir;

    public function __construct()
    {
        $this->middleware('admin');

        switch(\App::getLocale())
        {
            case 'ru':
                $this->localeDir = 'ru.';
                break;
            default:
                $this->localeDir = '';
        }
    }

    public function index()
    {
        $forModeration=\App\Moderation::all();
        $status=\App\Myclasses\Arrays::moderationMarks();
        return view($this->localeDir.'administration.moderation', compact('forModeration', 'status'));
    }

    public function delprove(Request $request)
    {
        $todo=$request->all();
        switch($todo['action']){
            case 'delete':
                $aim=\App\Moderation::find($todo['target']);
                $reciever=$aim->user_id;
                $addr=$aim->address;
                $decision=\App\Myclasses\Response::moderationResultMessage('no', $reciever);
                $aim->delete();
                break;
            case 'approve':
                $aim=\App\Moderation::find($todo['target']);
                $reciever=$aim->user_id;
                $addr=$aim->address;
                $decision=\App\Myclasses\Response::moderationResultMessage('yes', $reciever);
                $data=unserialize($aim->data);
                $save=new \App\Myclasses\Savers\planetSaver($data);
                if ($save->getMessage()=='ok')
                    $aim->delete();
                break;
            default:
                $aim=\App\Moderation::find($todo['target']);
                $reciever=$aim->user_id;
                $addr=$aim->address;
                $decision=\App\Myclasses\Response::moderationResultMessage('restrict', $reciever);
                $data=unserialize($aim->data);
                $save=new \App\Myclasses\Savers\planetSaver($data, 'restrict');
                if ($save->getMessage()=='ok')
                    $aim->delete();
        }
        $letter=\App\Myclasses\Response::moderationLetter($addr, $decision, $reciever);
        $myMessage=new \App\Myclasses\localLetters\adminMail($letter);
        $myMessage->send();
        return redirect('/administration');
    }

    public function request(Request $request)
    {
        $data=$request->all();
        $signature=\Auth::user()->name;
        $aim=\App\Moderation::find($data['target']);
        $letter=\App\Myclasses\Response::moreInfoLetter($aim);
        $myMessage=new \App\Myclasses\localLetters\adminMail($letter);
        $myMessage->send();
        $aim->request='sent';
        $aim->save();
        return redirect('/administration');
    }

    public function mail(Request $request, $folder='inbox')
    {
        $letterId=$request->input('letter');
        if(isset($letterId))
        {
            $letter=\App\Letter::find($letterId);
            if ($letter)
            {
                if ($letter->reciever == 1)
                {
                    $letter->status='read';
                    $letter->save();
                    return view($this->localeDir.'administration.singleLetter', compact('letter'));
                }
                elseif ($letter->sender == 1)
                {
                    return view($this->localeDir.'administration.singleLetter', compact('letter'));
                }
                return redirect('/administration/mail');
            }
            else return redirect('/administration/mail');
        }
        else
        {
            $navigation = \App\Myclasses\Arrays::mailNav($folder);

            switch($folder)
            {
                case 'inbox':
                    $letters= \App\User::find(1)->hasInbox()->where('show_reciever', 'true')->orderBy('id', 'desc')->get();
                    return view ($this->localeDir.'administration.inbox', compact('letters', 'navigation'));

                case 'sent':
                    $letters= \App\User::find(1)->hasSent()->where('show_sender', 'true')->orderBy('id', 'desc')->get();
                    return view ($this->localeDir.'administration.sent', compact('letters', 'navigation'));

                case 'new':
                    $users=\App\User::all();
                    return view($this->localeDir.'administration.newmail', compact('users', 'navigation'));
            }
            return view($this->localeDir.'administration.adminmail');
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
        $redirect = $request->input('back');
        $deleter = new \App\Myclasses\localLetters\mailDeleter($id, 1);
        return redirect(route('adminmail', ['folder'=>$redirect]));
    }

    public function massDelete(Request $request)
    {
        $idArray = $request->all();
        foreach ($idArray as $id => $status)
        {
            if ($status != 'on')
                continue;
            $deleter = new \App\Myclasses\localLetters\mailDeleter($id, 1);
        }
        return redirect()->back();
    }

    public function search(Requests\SearchRequest $request)
    {
        $selRep=session('result');
        $searchData=$request->all();
        $regions=\App\Region::all();
        $nothing = \App\Myclasses\Response::requestResult('nothing');
        if($searchData) {
            $searching = new \App\Myclasses\search\SearchEngine($searchData);
            $systemDs = $searching->getResult();
            if ($systemDs) {
                return view($this->localeDir.'administration.search', compact('regions', 'systemDs', 'searchData', 'selRep'));
            } else {
                return view($this->localeDir.'administration.search', compact('regions', 'nothing', 'searchData'));
            }
        }
        return view($this->localeDir.'administration.search', compact('regions', 'selRep'));
    }

    public function delete(Request $request)
    {
        $target=$request->only('target');
        if(!\Auth::user()->isModerator()) return redirect(route('search'))->with('result', \App\Myclasses\Response::requestResult('noright'));
        if(\App\Myclasses\Insides\Terminator::deleteAddress($target))return redirect(route('search'))->with('result', \App\Myclasses\Response::requestResult('delok'));
        else return redirect(route('search'))->with('result', \App\Myclasses\Response::requestResult('delfail'));

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
                    return back()->with('result', \App\Myclasses\Response::requestResult('noright'));
                }
                $result=new \App\Myclasses\Savers\Deleter($object, $data);
                break;
        }
        switch($result->getMessage())
        {
            case 'ok':
                $response=\App\Myclasses\Response::requestResult('changeok');
                break;
            case 'fail':
                $response=\App\Myclasses\Response::requestResult('changefail');
        }

        return back()->with('result', $response);
    }
}
