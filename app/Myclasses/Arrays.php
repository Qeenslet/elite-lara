<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 21.06.2015
 * Time: 13:05
 */

namespace App\Myclasses;


class Arrays {
    public static function allStarsArray() {
        return array('A', 'F', 'G', 'K', 'M', 'B', 'AeBe', 'CN', 'D', 'MS', 'L', 'T', 'TTS', 'Y', 'W', 'N', 'BH', 'O');
    }

    public static function planetTypeArray() {
        return array('Т-металлик', 'Т-водные', 'Т-каменистые', 'Землеподобные', 'Водные', 'Аммиачные');
    }

    public static function planetsForCabinet(){
        return array('T-HM', 'T-WW', 'T-RW', 'EL', 'WW', 'AW');
    }

    public static function sizeTypeArray() {
        return array('0', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII');
    }

    public static function stopList() {
        return array(5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17);
    }

    public static function colorList() {
        return array('Т-металлик'=>'rgb(255, 107, 1)',
            'Т-водные' =>'rgb(0, 209, 242)',
            'Т-каменистые'=>'rgb(163, 82, 0)',
            'Землеподобные'=>'rgb(0, 132, 0)',
            'Водные'=>'rgb(119, 152, 191)',
            'Аммиачные'=>'rgb(102, 51, 0)',
            'M'=>'rgb(255, 107, 1)',
            'K'=>'rgb(255, 204, 0)',
            'G'=>'rgb(255, 255, 0)',
            'F'=>'rgb(255, 255, 153)',
            'A'=>'rgb(240, 255, 255)',
            'редкие'=>'rgb(204, 153, 255)',
            'аммиачные'=>'rgb(102, 51, 0)',
            'водные не пригодные к ТФ'=>'rgb(119, 152, 191)',
            'пригодные к ТФ без земных'=>'rgb(0, 255, 255)',
            'земные и пригодные к ТФ'=>'rgb(102, 255, 153)',
            'земные'=>'rgb(0, 132, 0)');
    }

    public static function rankList() {
        return array('Новичок', 'Почти новичок', 'Разведчик', 'Инспектор', 'Пионер', 'Следопыт', 'Рейнджер', 'Первопроходец', 'Элита');

    }
    public static function rankLogo() {
        return array('Aimless.png', 'Mostly-Aimless.png', 'Scout.png', 'Surveyor.png', 'Trailblazer.png', 'Pathfinder.png', 'Ranger.png', 'Pioneer.png', 'Elite.png');

    }

    public static function moderationMarks(){
        return ['danger'=>'превышение зоны распределения', 'warning'=>'слишком мало соседей'];
    }
    public static function cabinetRouts(){
        return ['cabinet'=>'Статистика', 'discovery'=>'Журнал систем', 'usermail'=>'Почта'];
    }
    public static function adminRouts(){
        return ['administration'=>'Системы на модерацию', 'adminmail'=>'Почта', 'search'=>'Поиск по базе'];
    }
    public static function moderRouts(){
        return ['moderation'=>'Главная', 'reader'=>'Пакетный ввод', 'roles'=>'Доступ пользователей', 'texts'=>'Тексты на сайт'];
    }
}