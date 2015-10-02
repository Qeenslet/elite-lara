<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 02.10.2015
 * Time: 7:41
 */

namespace App\Myclasses\localLetters;


class mailDeleter {

    protected $letter;
    protected $userId;

    public function __construct($id, $user = null)
    {
        $this->letter = \App\Letter::find($id);
        if (isset($user))
            $this->userId = $user;
        else
        {
            $this->userId = \Auth::user()->id;
        }
        $this->markDelete();
        $this->checkMarks();
    }

    protected function markDelete()
    {
        if($this->letter->sender == $this->userId)
        {
            $this->letter->show_sender='false';
        }
        else
        {
            $this->letter->show_reciever='false';
        }
        $this->letter->save();

    }

    protected function checkMarks()
    {
        if($this->letter->show_sender == 'false' && $this->letter->show_reciever == 'false')
        {
            $this->letter->delete();
        }
    }
}