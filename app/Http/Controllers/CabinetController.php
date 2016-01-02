<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Myclasses\Arrays;
use Auth;
use Golonka\BBCode\BBCodeParser;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CabinetController extends Controller {

    protected $localeDir;

    public function __construct(){
        $this->middleware('cabinet');

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
        $myRank=\App\Myclasses\Rank::getRank();
        return view($this->localeDir.'cabinet.stats', compact('myRank'));
    }

    public function mail(Request $request, $folder='inbox')
    {
        $letterId=$request->input('letter');
        if(isset($letterId))
        {
            $letter=\App\Letter::find($letterId);
            if ($letter)
            {
                $id = Auth::user()->id;
                if ($letter->reciever == $id)  //the letter is sent to user
                {
                    $letter->status='read';
                    $letter->save();
                    return view($this->localeDir.'cabinet.singleLetter', compact('letter'));
                }
                elseif ($letter->sender == $id)  //the user has sent the letter
                {
                    return view($this->localeDir.'cabinet.singleLetter', compact('letter'));
                }
                return redirect('/cabinet/mail'); //the letter does not belong to user
            }
            else return redirect('/cabinet/mail'); //the letter does not exist
        }
        else //no letter is mentioned
        {
            $navigation = Arrays::mailNav($folder);

            switch($folder)
            {
                case 'inbox':
                    $letters= Auth::user()->hasInbox()->where('show_reciever', 'true')->orderBy('id', 'desc')->get();
                    return view($this->localeDir.'cabinet.inbox', compact('letters', 'navigation'));

                case 'sent':
                    $letters= Auth::user()->hasSent()->where('show_sender', 'true')->orderBy('id', 'desc')->get();
                    return view($this->localeDir.'cabinet.sent', compact('letters', 'navigation'));

                case 'new':
                    $users=\App\User::all();
                    return view($this->localeDir.'cabinet.newmail', compact('users', 'navigation'));
            }
        }
    }

    public function sender(Requests\LetterFilter $request)
    {
        //recieving letter details from the form
        $mess=$request->except('_token');
        //filtering
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
        //sending letter
        $myLetter=new \App\Myclasses\localLetters\userMail($filteredMess);
        $myLetter->send();
        //redirecting
        return redirect('/cabinet/mail');

    }

    public function discovery(Request $request)
    {
        $s = $request->input('start');
        $e = $request->input('end');
        if (isset($s))
        {
            if (preg_match('/^(\d{2})\.(\d{2})\.(\d{4})$/', $s, $match))
            {
                if ($match[1] > 31 || $match[2] > 12) abort(404);
                $start = \Carbon\Carbon::parse($s);
                if (isset($e))
                {
                    if (preg_match('/^(\d{2})\.(\d{2})\.(\d{4})$/', $e, $match))
                    {
                        if ($match[1] > 31 || $match[2] > 12) abort(404);
                        $end = \Carbon\Carbon::parse($e);
                    }
                    else
                    {
                        abort(404);
                    }
                }
                else
                {
                    $end = \Carbon\Carbon::now();
                }
                $findings= Auth::user()->findings()
                    ->whereBetween('created_at', [$start, $end])
                    ->groupBy('created_at')
                    ->orderBy('id', 'desc')
                    ->paginate(10);
                $s = $start->format('d.m.Y');
                $e = $end->format('d.m.Y');
                $findings->appends(['start' => $s, 'end' => $e]);
            }
            else
            {
                abort(404);
            }
        }
        else
        {
            $findings= Auth::user()->findings()
                ->groupBy('created_at')
                ->orderBy('id', 'desc')
                ->paginate(10);
            $s = '';
            $e = '';
        }
        return view($this->localeDir.'cabinet.discoveries', compact('findings', 's', 'e'));
    }

    public function mailDelete(Request $request)
    {
        $id=$request->input('id');
        $redirect = $request->input('back');
        $deleter = new \App\Myclasses\localLetters\mailDeleter($id);
        return redirect(route('usermail', ['folder'=>$redirect]));
    }

    public function massDelete(Request $request)
    {
        $idArray = $request->all();
        foreach ($idArray as $id => $status)
        {
            if ($status != 'on')
                continue;
            $deleter = new \App\Myclasses\localLetters\mailDeleter($id);
        }
        return redirect()->back();
    }

    public function totalStats()
    {
        $points = \App\Point::orderBy('points', 'desc')->get();
        return view ($this->localeDir.'cabinet.totalStats', compact('points'));

    }

    public function cabinetSearch(Request $request)
    {
        $selRep=session('result');
        $searchData=$request->all();
        $regions=\App\Region::all();
        $nothing = \App\Myclasses\Response::requestResult('nothing');
        if(isset ($searchData['star']) && isset($searchData['planet']) )
        {
            $searchData['user_search'] = 1;
            $searching = new \App\Myclasses\search\SearchEngine($searchData);
            $systemDs = $searching->getResult();
            if ($systemDs) {
                return view($this->localeDir.'cabinet.search', compact('regions', 'systemDs', 'searchData', 'selRep'));
            } else {
                return view($this->localeDir.'cabinet.search', compact('regions', 'nothing', 'searchData'));
            }
        }
        return view($this->localeDir.'cabinet.search', compact('regions', 'selRep'));
    }

}
