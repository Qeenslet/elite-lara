<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Region;
use Illuminate\Http\Request;

class ModerationController extends Controller {

    public function __construct()
    {
        $this->middleware('moderator');
    }

    public function index()
    {
        $users=\App\User::all();
        $latest=\App\Myclasses\Counter::todayStats();
        $locs=\App\Location::all();
        $locations=new \App\Myclasses\Mapper($locs);
        return view('moderation.first', compact('users', 'latest', 'locations'));
    }
    public function reader()
    {
        return view('moderation.reader');
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
        return view('moderation.report', compact('total', 'repModer', 'repFails', 'repSim', 'fails', 'oks'));
    }

    public function roles()
    {
        $users=\App\User::all();
        return view('moderation.roles', compact('users'));
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
        }
        return redirect(route('roles'));
    }

    public function texts()
    {
        $texts=\App\Maintext::all();
        return view('moderation.texts', compact('texts'));
    }

    public function changer(Request $request)
    {
        $article=$request->all();
        $text=\App\Maintext::find($article['id']);
        $text->name=$article['name'];
        $text->body=$article['body'];
        $text->save();
        return redirect(route('texts'));

    }

    public function multistars()
    {
        $addresses=\App\Address::all();
        $selected=[];
        foreach($addresses as $address){
            $num=$address->stars()->count();
            if($num>1){
                foreach($address->stars()->get() as $singleStar){
                    if($singleStar->code!=NULL) continue;
                    else {
                        $selected[]=$address;
                        break;
                    }
                }
            }
            else{
                $star=$address->stars()->first();
                if($star->code!=NULL) continue;
                $star->code='A';
                $star->save();
            }
        }
        $starNames=\App\Myclasses\Arrays::allStarsArray();
        $sizeNames=\App\Myclasses\Arrays::sizeTypeArray();

        return view('moderation.multistars', compact('selected', 'starNames', 'sizeNames'));
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
            return view('moderation.recent', compact('address'));
        }
        return view('moderation.recent');
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

        $newData=\App\Myclasses\SystemInsider::rebuild($address->id);
        $address->inside->data=serialize($newData);
        $address->inside->save();
        return back();
        /*
        $check=\App\Region::where('name', $data['region'])->first()
            ->addresses()->where('name', $data['address'])->first();
        if ($check){
            $oldId=$check->id;
            if($oldId!=$data['adrId']) {
                \App\Myclasses\Uniter::unite($oldId, $data['adrId']);
            }
        }
        else{
            $reg=\App\Region::where('name', $data['region'])->first();
            if(!$reg){
              $reg= new \App\Region;
                $reg->name=$data['region'];
                $reg->save();
            }
            $regId=$reg->id;
            $address=\App\Address::find($data['adrId']);
            $address->region_id=$regId;
            $address->name=$data['address'];
            $address->save();

            $newData=\App\Myclasses\SystemInsider::rebuild($address->id);
            $address->inside->data=serialize($newData);
            $address->inside->save();
        }
        return back();*/

    }

    public function unite()
    {
        return view('moderation.test');
        /*$addresses=\App\Address::all();
        $count=0;
        $fails=0;
        foreach ($addresses as $address){
            $addressId=$address->id;
            $regionId=$address->region->id;
            $rawStars=$address->stars()->get();
            $stars=[];
            $planets=[];
            foreach($rawStars as $one){
                $star=$one->star;
                $size=$one->size;
                $class=$one->class;
                $code=$one->code;
                $user=$one->user_id;
                $stars[$one->id]=new \App\Myclasses\StarInfo($code, $star, $size, $class, $user);
                $planetsInside=[];
                foreach($one->planets()->get() as $ppp){
                    $planet=$ppp->planet;
                    $distance=$ppp->distance;
                    $mark=$ppp->mark;
                    $userP=$ppp->user_id;
                    $planetsInside[$ppp->id]=new \App\Myclasses\PlanetInfo($planet, $distance, $mark, $userP);
                }
                $planets[$one->id]=$planetsInside;
            }
            $data=new \App\Myclasses\SystemInsider($regionId, $addressId, $stars, $planets);
            $sData=serialize($data);
            $save=\App\Inside::create(['address_id'=>$addressId, 'data'=>$sData]);
            if($save) $count++;
            else $fails++;
        }
        return view('moderation.unite', compact('count', 'fails'));

        $first=\Session::pull('first');
        $second=\Session::pull('second');
        return view('moderation.unite', compact('first', 'second'));*/
    }

    public function deleteUser(Request $request)
    {
        $id=$request->input('id');
        if($id==1) return redirect(route('roles'));
        $user=\App\User::find($id);
        if($user->confirmed!='confirmacion ha pasado' || $user->findings()->count()==0){
            $user->points()->delete();
            $user->roles()->detach(1);
            $user->delete();
            return redirect(route('roles'));
        }
        else {
            $user->roles()->detach(1);
            return redirect(route('roles'));
        }
    }

}
