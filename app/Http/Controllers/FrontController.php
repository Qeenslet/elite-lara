<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Maintext;
use App\Myclasses\Counter;
use Illuminate\Http\Request;

class FrontController extends Controller {

	public function index(){
        $content=Maintext::find(1);
        $loginfo=\Session::pull('loginfo');
        if(!$loginfo) $loginfo=null;
        return view('templates.content', compact('content', 'loginfo'));
    }

    public function database(){
        return view('templates.database');
    }

    public function adding(){
        $regions=\App\Region::all();
        $stars=\App\Myclasses\Arrays::allStarsArray();
        $sizes=\App\Myclasses\Arrays::sizeTypeArray();
        $planets=\App\Myclasses\Arrays::planetsForCabinet();
        return view('templates.add', compact('regions', 'stars', 'sizes', 'planets'));
    }

    public function staticPage($url){
        $content= Maintext::where('url', $url)->firstOrFail();
        return view('templates.content', compact('content'));
    }

}
