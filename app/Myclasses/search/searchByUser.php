<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 23.08.2015
 * Time: 14:07
 */

namespace App\Myclasses\search;


class searchByUser extends SearchEngine{
    protected $user;
    protected $ids;

    public function __construct($data)
    {
        $this->data=$data;
        $this->user=\App\User::where('name', $this->data['user'])->first();
        if($this->user){
            $this->search();
        }
    }

    protected function search()
    {
        $findings=$this->user->findings()->orderBy('id', 'desc')->get();
        foreach($findings as $one){
            $this->ids[]=$one->address->id;
        }
    }

    public function getIdsArray()
    {
        return $this->ids;
    }
}