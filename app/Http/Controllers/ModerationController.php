<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Region;
use Illuminate\Http\Request;

class ModerationController extends Controller {

    protected $localeDir;

    public function __construct()
    {
        $this->middleware('moderator');

        /*switch(\App::getLocale())
        {
            case 'ru':
                $this->localeDir = 'ru.';
                break;
            default:
                $this->localeDir = '';
        }*/
        $this->localeDir = '';
    }

    public function index()
    {
        $users=\App\User::all();
        $latest=\App\Myclasses\Counter::todayStats();
        $locs=\App\Location::week()->get();
        $locations=new \App\Myclasses\Mapper($locs);
        $statData=new \App\Myclasses\charters\charterModer();
        return view($this->localeDir.'moderation.first', compact('users', 'latest', 'locations', 'statData'));
    }

    public function reader()
    {
        return view($this->localeDir.'moderation.reader');
    }

    public function reporter(Requests\FileRequest $request)
    {
        $request->file('filename')->move(storage_path(), 'report.txt');
        return redirect(route('reportResult'));

    }
    public function result()
    {
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
        return view($this->localeDir.'moderation.report', compact('total', 'repModer', 'repFails', 'repSim', 'fails', 'oks'));
    }

    public function roles()
    {
        $users=\App\User::all();
        return view($this->localeDir.'moderation.roles', compact('users'));
    }
    public function setRoles(Request $request)
    {
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
            case 'looselang':
                \App\User::find($id)->locales()->detach($role);
        }
        return redirect(route('roles'));
    }

    public function texts()
    {
        $texts=\App\Maintext::all();
        return view($this->localeDir.'moderation.texts', compact('texts'));
    }

    public function changer(Request $request)
    {
        $article=$request->all();
        $text=\App\Maintext::find($article['id']);
        $text->name=$article['name'];
        $text->body=$article['body'];
        $text->en_name=$article['en_name'];
        $text->en_body=$article['en_body'];
        $text->save();
        return redirect(route('texts'));

    }

    public function multistars()
    {
        $els = \App\Planet::where('planet', 1)->wherePlandataPrice()->get();
        $first = $els[0];
        $firstG = \App\Myclasses\Counter::gravity($first->mass, $first->radius);
        foreach($els as $el)
        {
            $gravity = \App\Myclasses\Counter::gravity($el->mass, $el->radius);
            $gDiffer = round($gravity / ($firstG / 100) / 100, 2);
            $pDiffer = round($el->price / ($first->price / 100) / 100, 2);
            $oxyDiffer = round($el->oxy / ($first->oxy / 100) / 100, 2);
            $tempDiffer = round($el->temperature  /($first->temperature / 100) / 100, 2);
            $pressDiff = round($el->pressure / ($first->pressure / 100) / 100, 2);
            $dayDiff = round($el->rotP / ($first->rotP / 100) / 100, 2);
            $array[] = $gDiffer.'G'.'+'.$dayDiff.'Day'.'+'.$oxyDiffer.'O2'.'+'.$tempDiffer.'T'.'+'.$pressDiff.'Pa = '.$pDiffer;
        }
        dd($array);
    }

    public function starpos(Request $request)
    {
        $data=$request->except('_token');
        foreach($data as $key=>$value) {
            $star = \App\Star::find($key);
            $star->code = $value;
            $star->save();
        }
        return redirect(route('multi'));

    }
    public function recent(Request $request)
    {
        $name=$request->input('region');
        if(isset($name)) {
            $address = \App\Region::where('name', $name)->first()->addresses()->orderBy('id', 'desc')->get();
            return view($this->localeDir.'moderation.recent', compact('address'));
        }
        return view($this->localeDir.'moderation.recent');
    }

    public function changeData(Request $request)
    {
        $data=$request->except('_token');
        $reg=\App\Region::where('name', $data['region'])->first();
        if ($reg){
            $addr=$reg->addresses()->where('name', $data['address'])->first();
            if($addr){
                $oldId=$addr->id;
                if($oldId!=$data['adrId']) {
                    \App\Myclasses\Uniter::unite($oldId, $data['adrId']);
                }
                return back();
            }
        }
        else {
            $reg= new \App\Region;
            $reg->name=$data['region'];
            $reg->save();
        }
        $regId=$reg->id;
        $address=\App\Address::find($data['adrId']);
        $address->region_id=$regId;
        $address->name=$data['address'];
        $address->save();

        $newData=new \App\Myclasses\Insides\Insider($address);
        $address->inside->data=serialize($newData);
        $address->inside->save();
        return back();
    }

    public function unite()
    {
        $pilot = \App\User::where('name', 'Qeenslet')->first();
        dd($pilot->locales()->where('lang', 'en')->first());

        //return ('Get lost out of here!!!');
        /*$array=['id'=>15];
        $object='star';
        $aa=new\App\Myclasses\Savers\Rewriter($object, $array);
        dd($aa);

        $addrs=\App\Address::all();
        $fuckup=[];
        foreach($addrs as $addr){
            if (!$addr->inside()->first()){
                $fuckup[]=$addr->region->name." ".$addr->name;
            }
        }
        return $fuckup;
        $statData=new \App\Myclasses\charterModer();
        return view('moderation.test', compact('statData'));*/

        /*$insider = new \App\Myclasses\Insides\Converter(1114);
        dd($insider);*/
       /*$addresses=\App\Address::find(1114);
        $newData=new \App\Myclasses\Insides\Insider($addresses);
        $addresses->inside->data=serialize($newData);
        if($addresses->inside->save()) return 'coll';*/
        /*$count=0;
        $fails=0;
        foreach ($addresses as $address){
            $addressId=$address->id;
            $data=new \App\Myclasses\Insides\Insider($address);
            $sData=serialize($data);
            $save=\App\Inside::create(['address_id'=>$addressId, 'data'=>$sData]);
            if($save) $count++;
            else $fails++;
        }
        return view($this->localeDir.'moderation.unite', compact('count', 'fails'));*/


        /*$first=\Session::pull('first');
        $second=\Session::pull('second');
        return view($this->localeDir.'moderation.unite', compact('first', 'second'));*/
    }

    public function deleteUser(Request $request)
    {
        $id=$request->input('id');
        if($id == 1) return redirect(route('roles'));
        $user=\App\User::find($id);
        if($user->confirmed != 'confirmacion ha pasado' || $user->findings()->count() == 0){
            $user->points()->delete();
            $user->roles()->detach(1);

            foreach($user->hasSent()->get() as $letter)
            {
                $letter->delete();
            }
            foreach($user->hasInbox()->get() as $letter)
            {
                $letter->delete();
            }
            $user->delete();
            return redirect(route('roles'));
        }
        else {
            $user->roles()->detach(1);
            return redirect(route('roles'));
        }
    }

}
