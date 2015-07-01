<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Golonka\BBCode\BBCodeParser;
use Illuminate\Http\Request;

class CabinetController extends Controller {

    public function __construct(){
        $this->middleware('cabinet');
    }
	public function index(){
        $myRank=\App\Myclasses\Rank::getRank();
        return view('cabinet.stats', compact('myRank'));
    }

    public function mail(Request $request){
        $letterId=$request->input('letter');
        if(isset($letterId)){
            $letter=\App\Letter::find($letterId);
            if ($letter) {
                $id = \Auth::user()->id;
                if ($letter->reciever == $id) {
                    $letter->status='read';
                    $letter->save();
                    return view('cabinet.singleLetter', compact('letter'));
                }
                elseif ($letter->sender == $id) {
                    return view('cabinet.singleLetter', compact('letter'));
                }
                return redirect('/cabinet/mail');
            }
            else return redirect('/cabinet/mail');
        }
        else {
            return view('cabinet.usermail');
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
        \Auth::user()->hasSent()->save($letter);
        return redirect('/cabinet/mail');

    }

    public function discovery(){
        $findings=\Auth::user()->findings()->groupBy('created_at')->orderBy('id', 'desc')->paginate(10);
        return view('cabinet.discoveries', compact('findings'));
    }

}
