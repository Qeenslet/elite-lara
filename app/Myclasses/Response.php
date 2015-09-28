<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 09.09.2015
 * Time: 6:22
 */

namespace App\Myclasses;


class Response {

    public static function moreInfoLetter(\App\Moderation $aim)
    {
        $signature=\Auth::user()->name;
        $letter['reciever']=$aim->user_id;
        $reciever=\App\User::find($aim->user_id);
        $name=$reciever->name;
        if($reciever->hasLocale('ru'))
        {
            $letter['header'] = "Запрос на дополнительные данные по системе $aim->address";
            $letter['body'] = "Добрый день, CMDR $name! К сожалению, нам недостаточно данных для одобрения добавленной вами планеты в системе $aim->address.
            Пришлите, если это возможно, скриншот карты системы. Для его включения в письмо можете воспользоваться любым сервисом хранения загруженных фотографий.
            С уважением, администратор $signature.";
        }
        else
        {
            $letter['header'] = "Request for additional info about the star system $aim->address";
            $letter['body'] = "Hello, CMDR $name! Unfortunately we don't have enough data to approve the planet you have added in the system $aim->address.
            Send us if it is possible the screenshot of this system. To include it in the letter you may use any web service of sharing photos.
            Best regards, administrator $signature.";
        }
        return $letter;
    }

    public static function moderationLetter($addr, $decision, $reciever)
    {
        $user=\App\User::find($reciever);
        if($user->hasLocale('ru')) $locale='ru';
        else $locale='en';
        $signature=\Auth::user()->name;
        $letter['reciever'] = $reciever;
        switch ($locale) {
            case 'ru':
                $letter['header'] = "Решение по системе $addr";
                $letter['body'] = "Добрый день! В результате модерации объекта в системе $addr, $decision. С уважением, администратор $signature.";
                break;
            default:
                $letter['header'] = "Decision about the system $addr";
                $letter['body'] = "Hello! Due to the moderation procedure the planet in $addr, $decision. Best regards, administrator $signature.";
                break;

        }
        return $letter;

    }

    public static function noData()
    {
        switch(\App::getLocale())
        {
            case 'ru':
                return '<h3>По данному типу звезд еще не собрано достаточно данных!</h3>';
            default:
                return '<h3>Not enough data to build the chart for this type of stars</h3>';
        }
    }

    public static function moderationResultMessage($answer, $id)
    {
        $user=\App\User::find($id);
        if($user->hasLocale('ru')) $locale='ru';
        else $locale='en';
        switch ($answer)
        {
            case 'no':
                $resp['ru']='внесенные вами данные не были одобрены администратором';
                $resp['en']="has not been approved by the administrator";
                break;
            case 'restrict':
                $resp['ru']='внесенные вами данные были одобрены без права индексации';
                $resp['en']="has been approved with indexation restrictions";
                break;
            default:
                $resp['ru']='внесенные вами данные были одобрены и добавлены в базу';
                $resp['en']="has been approved by the administrator";
                break;
        }
        return $resp[$locale];
    }

    public static function requestResult($result)
    {
        switch(\App::getLocale())
        {
            case 'ru':
                $array['nothing']='Ничего не было найдено';
                $array['noright']='У вас нет прав для удаления объекта';
                $array['delok']='Успешно удалено';
                $array['delfail']='Возникла ошибка при удалении';
                $array['changeok']='Данные были успешно изменены';
                $array['changefail']='Произошел сбой при изменении';
                $array['confirm']='Ваш email подтвержден';
                $array['unconfirm']='Произошел сбой. Ваш email не был подтвержден!';
                $array['faillogin']='Что неверно: логин или пароль, или и то, и другое';
                return $array[$result];
            default:
                $array['nothing']='Nothing has been found';
                $array['noright']='You have no rights to delete objects';
                $array['delok']='Object has been deleted';
                $array['delfail']='The error has occurred while deleting';
                $array['changeok']='The data was successfully updated';
                $array['changefail']='The update has failed';
                $array['confirm']='Your email has been confirmed';
                $array['unconfirm']='Something has gone wrong. Your email has not been confirmed';
                $array['faillogin']='These credentials do not match our records.';
                return $array[$result];
        }
    }

}