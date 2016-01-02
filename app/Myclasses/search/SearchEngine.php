<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 23.08.2015
 * Time: 13:05
 */

namespace App\Myclasses\search;


use Illuminate\Support\Facades\App;

class SearchEngine {

    protected $data;
    protected $result;
    private $object;
    private $resultArray;

    function __construct($data)
    {
        $this->data = $data;

        if (isset($data['address'])) $this->object=new searchSystem($this->data);
        if (isset($data['distance'])) $this->object=new searchByParams($this->data);
        if (isset($data['user'])) $this->object=new searchByUser($this->data);
        if (isset($data['rare_star'])) $this->object=new searchRare($this->data);
        if (isset($data['user_search'])) $this->object = new cabinetSearch($this->data);

        $this->doSearch();
    }

    protected function doSearch()
    {
        if($this->object){
            $this->resultArray=$this->object->getIdsArray();
            if($this->resultArray) {
                $this->fillResult();
            }

        }
    }

    protected function fillResult()
    {
        foreach($this->resultArray as $one){
            if($one) $this->result[$one]=new \App\Myclasses\Insides\Converter($one);
        }
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }


}