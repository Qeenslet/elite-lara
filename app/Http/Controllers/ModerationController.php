<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ModerationController extends Controller {

    public function __construct(){
        $this->middleware('moderator');
    }

    public function index(){
        return view('moderation.first');
    }
    public function reader(){
        return view('moderation.reader');
    }
    public function reporter(Requests\FileRequest $request){
        $request->file('filename')->move(storage_path(), 'report.txt');
        return redirect(route('reportResult'));

    }
    public function result(){
        $fp = fopen(storage_path().'\report.txt', 'r');
        $total=$fails=$oks=0;
        $repModer=[];
        $repFails=[];
        $repSim=[];
        while (!feof($fp)){
            $string = fgets($fp, 99);
            $results=\App\Myclasses\ReporReader::analize($string);
            if($results!=1){
                switch ($results){
                    case 2:
                        $repModer[$string]="Система добавлена на модерацию";
                        break;
                    case 3:
                        $repFails[$string]="Ошибка распознавания";
                        break;
                    case 4:
                        $repSim[$string]="Система уже есть в базе данных";

                }
                $repRes[]=$results;
                $fails++;
            }
            else {
                $oks++;
            }
            $total++;
        }
        fclose($fp);
        return view('moderation.report', compact('total', 'repModer', 'repFails', 'repSim', 'fails', 'oks'));
    }
    public function roles(){
        $users=\App\User::all();
        return view('moderation.roles', compact('users'));
    }
    public function setRoles(Request $request){
        $action=$request->input('action');
        $role=$request->input('role');
        $id=$request->input('user');
        if($id==1) return redirect(route('roles'));
        switch($action){
            case 'cancel':
                \App\User::find($id)->roles()->detach($role);
                break;
            case 'give':
                \App\User::find($id)->roles()->attach($role);
                break;
        }
        return redirect(route('roles'));
    }

    public function texts(){
        $texts=\App\Maintext::all();
        return view('moderation.texts', compact('texts'));
    }

    public function changer(Request $request){
        $article=$request->all();
        $text=\App\Maintext::find($article['id']);
        $text->name=$article['name'];
        $text->body=$article['body'];
        $text->save();
        return redirect(route('texts'));

    }

}
