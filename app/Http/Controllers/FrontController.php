<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Maintext;
use App\Myclasses\Checks\checkPlanet;
use App\Myclasses\Counter;
use App\Myclasses\Response;
use Illuminate\Http\Request;

class FrontController extends Controller {

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

    public function index()
    {
        $content=Maintext::find(1);
        $express = session('express');
        $loginfo=\Session::pull('loginfo');
        if(!$loginfo) $loginfo=null;
        return view($this->localeDir.'templates.content', compact('content', 'loginfo', 'express'));
    }

    public function database($chart=0)
    {
        $navBar=\App\Myclasses\Arrays::chartNav();
        $total = count($navBar);
        $navigator=\App\Myclasses\Arrays::prepareNavigation($total, $chart);
        $count = \App\Myclasses\Arrays::allStarsArray(1);
        switch ($chart)
        {
            case 0:
                $charter=\App\Myclasses\charters\Charter::draw(0);
                $colors=\App\Myclasses\Arrays::colorList();
                return view ($this->localeDir.'chartforms.0', compact('chart', 'navBar', 'navigator', 'charter', 'colors'));
            case 1:
                return view ($this->localeDir.'chartforms.1', compact('chart', 'navBar', 'navigator', 'count'));
            case 2:
                return view ($this->localeDir.'chartforms.2', compact('chart', 'navBar', 'navigator'));
            case 3:
                return view ($this->localeDir.'chartforms.3', compact('chart', 'navBar', 'navigator', 'count'));
        }
    }

    public function adding()
    {
        $regions=\App\Region::all();
        $stars=\App\Myclasses\Arrays::allStarsArray(true);
        $sizes=\App\Myclasses\Arrays::sizeTypeArray();
        $planets=\App\Myclasses\Arrays::planetsForCabinet();
        return view($this->localeDir.'templates.add', compact('regions', 'stars', 'sizes', 'planets'));
    }

    public function staticPage($url)
    {
        $content= Maintext::where('url', $url)->first();
        if (!$content) abort(404);
        return view($this->localeDir.'templates.content', compact('content'));
    }

    public function extradd(Request $request, $address=null)
    {
        $result=session('result');
        $addrGet=$request->all();
        if(isset($addrGet['address'])){
            $searching = new \App\Myclasses\search\SearchEngine($addrGet);
            $systemDs = $searching->getResult();
            if ($systemDs) return view($this->localeDir.'templates.test', compact('systemDs', 'result'));
            else {
                $nothing=1;
                return view ($this->localeDir.'templates.test', compact('nothing'));
            }
        }
        if(isset($address)){
            $systemDs[$address]=new \App\Myclasses\Insides\Converter($address);
            return view($this->localeDir.'templates.test', compact('systemDs', 'result'));
        }
        $welcome=true;
        return view ($this->localeDir.'templates.test', compact('welcome'));
    }

    public function giveAddressAdder(Request $request)
    {
        $action=$request->input('go');
        if($action==1){
            return view($this->localeDir.'templates.addAddr');
        }

    }

    public function giveStarAdder(Request $request)
    {
        $stars=\App\Myclasses\Arrays::allStarsArray(true);
        $sizes=\App\Myclasses\Arrays::sizeTypeArray();
        $addrId=$request->input('id');
        if($addrId > 0){
            return view($this->localeDir.'templates.addStar', compact('stars', 'sizes', 'addrId'));
        }

    }

    public function givePlanetAdder(Request $request)
    {
        $addrId=$request->input('addr_id');
        $objId=$request->input('id');
        $type=$request->input('type');
        $planets=\App\Myclasses\Arrays::planetsForCabinet();
        if($addrId>0 && $objId>0){
            return view($this->localeDir.'templates.addPlanet', compact('planets', 'objId', 'type', 'addrId'));
        }

    }

    public function giveBaryAdder(Request $request)
    {
        $addrId=$request->input('id');
        $stars=\App\Myclasses\Arrays::allStarsArray(true);
        $sizes=\App\Myclasses\Arrays::sizeTypeArray();
        if($addrId>0){
            $converter=new \App\Myclasses\Insides\Converter($addrId);
            return view($this->localeDir.'templates.addBary', compact('stars', 'sizes', 'addrId', 'converter'));
        }

    }

    public function giveStarData(Request $request)
    {
       $type = $request->input('type');
        $starId = $request->input('id');
        if($type == 'star')
        {
            $star = \App\Star::find($starId);
            $sData = $star->starData()->first();
            if($sData)
            {
                return view ($this->localeDir.'templates.addStarData', compact('starId', 'sData'));
            }
            return view ($this->localeDir.'templates.addStarData', compact('starId'));
        }
        return 'its not a star';
    }

    public function givePlanetData(Request $request)
    {
        $type = $request->input('type');
        $pId = $request->input('id');
        switch($type)
        {
            case 'planet':
                $planet = \App\Planet::find($pId);
                $pData = $planet->planetData()->first();
                break;
            default:
                $planet = \App\Bariplanet::find($pId);
                $pData = $planet->planetData()->first();
        }

        if ($pData)
        {
            return view ($this->localeDir.'templates.addPlanetData', compact('pId', 'type', 'pData'));
        }
        return view ($this->localeDir.'templates.addPlanetData', compact('pId', 'type'));
    }

    /**
     * @param Requests\addrRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * saves address from the form if it does not exist and redirects to page to add more object data
     */
    public function addAddr(Requests\addrRequest $request)
    {
        //getting data from the form
        $data = $request->except('_token');

        //running check
        $check = new \App\Myclasses\Checks\checkAddr($data);

        //if the address is known redirecting
        if($check->result){
            return redirect(route('searchadd', ['address'=>$check->result]));
        }

        //else saving and redirecting

        $saver = new \App\Myclasses\Savers\addrSaver($check);
        return redirect(route('searchadd', ['address'=>$saver->getAddrId()]))->with('result', $saver->getMessage());
    }

    public function addStar(Requests\starRequest $request)
    {
        //getting data
        $data = $request->except('_token');

        //checking
        $check = new \App\Myclasses\Checks\checkStar($data);
        if($check->result)
        {
            return redirect(route('searchadd', ['address'=>$check->getAddressId()]))->with('result', 'sameStar');
        }
        else
        {
            //saving
            $saver = new \App\Myclasses\Savers\starSaver($check);
            //also the success message is necessary
            return redirect(route('searchadd', ['address'=>$saver->getAddrId()]))->with('result', $saver->getMessage());
        }
        //redirect back to the page with adding
    }

    public function addPlanet(Requests\planetRequest $request)
    {
        //getting data
        $data = $request->except('_token');
        //checking data
        $check = new \App\Myclasses\Checks\checkPlanet($data);
        if($check->result)
        {
            return redirect(route('searchadd', ['address'=>$check->getAddressId()]))->with('result', 'samePlanet');
        }
        else
        {
            $saver = \App\Myclasses\Checks\smartChecker::check($check);
            return redirect(route('searchadd', ['address'=>$saver->getAddrId()]))->with('result', $saver->getMessage());
            //also the success message is necessary
        }

        //do smth to check and save planet data if it is new to the database
        //redirect back to the page with adding
    }

    public function addBary(Requests\baryRequest $request)
    {
        $data = $request->except('_token');
        //checking
        $check = new \App\Myclasses\Checks\checkMulti($data);
        if($check->result)
        {
            return redirect(route('searchadd', ['address'=>$check->getAddressId()]))->with('result', 'sameBary');
        }
        else
        {
            $saver = new \App\Myclasses\Savers\multiSaver($check);
            return redirect(route('searchadd', ['address'=>$saver->getAddrId()]));

        }

    }

    public function addStarExtra(Requests\StarExtraRequest $request)
    {
        $data = $request->except('_token');
        $saver = new \App\Myclasses\Savers\starExtraSaver($data);

        return redirect(route('searchadd', ['address'=>$saver->getAddrId()]));
    }

    public function addPlanetExtra(Requests\planetExtrasAddRequest $request)
    {
        $data = $request->except('_token', 'ignoreMe');
        $saver = new \App\Myclasses\Savers\planetExtraSaver($data);

        return redirect(route('searchadd', ['address'=>$saver->getAddrId()]));

    }


    public function express(Request $request)
    {
        $data = $request->except('_token');
        $searching = new \App\Myclasses\search\fastSearch($data);
        return redirect()->back()->with('express', $searching);
    }

}
