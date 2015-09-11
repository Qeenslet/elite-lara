<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Golonka\BBCode\BBCodeParser;
use Illuminate\Http\Request;

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
	public function index(){
        $myRank=\App\Myclasses\Rank::getRank();
        return view($this->localeDir.'cabinet.stats', compact('myRank'));
    }

    public function mail(Request $request){
        $letterId=$request->input('letter');
        if(isset($letterId)){
            $letter=\App\Letter::find($letterId);
            if ($letter) {
                $id = Auth::user()->id;
                if ($letter->reciever == $id) {
                    $letter->status='read';
                    $letter->save();
                    return view($this->localeDir.'cabinet.singleLetter', compact('letter'));
                }
                elseif ($letter->sender == $id) {
                    return view($this->localeDir.'cabinet.singleLetter', compact('letter'));
                }
                return redirect('/cabinet/mail');
            }
            else return redirect('/cabinet/mail');
        }
        else {
            return view($this->localeDir.'cabinet.usermail');
        }
    }

    public function sender(Requests\LetterFilter $request){
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

    public function discovery(){
        $findings= Auth::user()->findings()->groupBy('created_at')->orderBy('id', 'desc')->paginate(10);
        return view($this->localeDir.'cabinet.discoveries', compact('findings'));
    }

    public function mailDelete(Request $request){
        $id=$request->input('id');
        $letter=\App\Letter::find($id);
        if($letter->sender==Auth::user()->id){
            $letter->show_sender='false';

        }
        else {
            $letter->show_reciever='false';
        }
        $letter->save();
        if($letter->show_sender=='false' && $letter->show_reciever=='false') {
            $letter->delete();
        }
        return redirect(route('usermail'));
    }

}
