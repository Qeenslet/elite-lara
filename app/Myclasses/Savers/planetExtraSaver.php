<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 25.09.2015
 * Time: 12:01
 */

namespace App\Myclasses\Savers;


class planetExtraSaver extends extraSaver {

    private $atmosphere;
    private $composition;
    private $orbit;
    private $common;

    private $planet;
    private $extras;
    private $bMark; //to check if it is baryplanet

    public function __construct($data)
    {
        parent::__construct();
        if(isset($data['locked']))
            $data['locked'] = 'locked';
        else
            $data['locked'] = 'no';

        $this->atmosphere = ['amm'=>$data['amm'],
                             'oxy'=>$data['oxy'],
                             'nit'=>$data['nit'],
                             'arg'=>$data['arg'],
                             'hel'=>$data['hel'],
                             'wat'=>$data['wat'],
                             'hyd'=>$data['hyd'],
                             'sud'=>$data['sud'],
                             'cad'=>$data['cad'],
                             'irn'=>$data['irn'],
                             'met'=>$data['met'],
                             'neo'=>$data['neo'],
                             'sil'=>$data['sil']];

        $this->composition = ['ice'=>$data['ice'],
                              'rock'=>$data['rock'],
                              'metal'=>$data['metal']];

        $this->orbit = ['orbP'=>$data['orbP'],
                        'mAxis'=>$data['mAxis'],
                        'ecce'=>$data['ecce'],
                        'incl'=>$data['incl'],
                        'peri'=>$data['peri'],
                        'rotP'=>$data['rotP'],
                        'aTilt'=>$data['aTilt'],
                        'locked'=>$data['locked']];

        $this->common = ['mass'=>$data['mass'],
                         'radius'=>$data['radius'],
                         'temperature'=>$data['temperature'],
                         'pressure'=>$data['pressure'],
                         'volcanism'=>$data['volcanism'],
                         'atm_type'=>$data['atm_type'],
                         'price'=>$data['price']];
        switch ($data['planet_type'])
        {
            case 'planet':
                $this->planet = \App\Planet::find($data['planet_id']);
                break;
            default:
                $this->planet = \App\Bariplanet::find($data['planet_id']);
                $this->bMark = true;
                break;
        }
        try{
            $this->defineAddress();
            $this->checkPresence();
            $this->savePoints();
        }
        catch (\PDOException $e){
            $this->rollback();
        }

    }

    private function checkPresence()
    {
        $this->extras = $this->planet->planetData()->first();

        if ($this->extras)
        {
            $this->rewrite();
        }
        else
        {
            $this->saveNew();
        }
    }

    protected function defineAddress()
    {
        if($this->bMark)
        {
            $this->address = $this->planet->center->address;
        }
        else
        {
            $this->address = $this->planet->star->address;
        }
    }

    protected function saveNew()
    {

        /*if ($this->bMark)
        {
            $this->common['bariplanet_id'] = $this->planet->id;
        }
        else
        {
            $this->common['planet_id'] = $this->planet->id;
        }*/
        $planetData = new \App\Plandata($this->common);
        $this->planet->planetData()->save($planetData);

        //$planetData = \App\Plandata::create($this->common);

        $orbit = new \App\Orbit($this->orbit);
        $planetData->orbit()->save($orbit);

        $composition = new \App\Composition($this->composition);
        $planetData->composition()->save($composition);

        $atmosphere = new \App\Atmosphere($this->atmosphere);
        $planetData->atmosphere()->save($atmosphere);

        $this->first = 1;
    }

    protected function rewrite()
    {
        $this->rewriter($this->extras, $this->common);
        $this->rewriter($this->extras->orbit, $this->orbit);
        $this->rewriter($this->extras->composition, $this->composition);
        $this->rewriter($this->extras->atmosphere, $this->atmosphere);

    }

    private function rewriter(\Illuminate\Database\Eloquent\Model $model, Array $array)
    {
        foreach ($array as $key=>$value)
        {
            $model->$key = $value;
        }
        $model->save();
    }
}