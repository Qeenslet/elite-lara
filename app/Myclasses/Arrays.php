<?php
/**
 * Created by PhpStorm.
 * User: egorg_000
 * Date: 21.06.2015
 * Time: 13:05
 */

namespace App\Myclasses;


use App\Moderation;

class Arrays {
    public static function allStarsArray($sort = false)
    {
        $array=['A', 'F', 'G', 'K', 'M', 'B', 'AeBe', 'C', 'D', 'MS', 'L', 'T', 'TTS', 'Y', 'W', 'N', 'BH', 'O', 'S'];

        //don't use asort in order to save server resources. This array doesn't change frequently
        $sortArray=[0 => "A",
                    6 => "AeBe Herbig",
                    5 => "B",
                    16 => "BH black hole",
                    7 => "C carbon",
                    8 => "D white dwarf",
                    1 => "F",
                    2 => "G",
                    3 => "K",
                    10 => "L",
                    4 => "M",
                    9 => "MS zircon",
                    15 => "N neutron",
                    17 => "O",
                    18 => "S zircon",
                    11 => "T brown dwarf",
                    12 => "TTS tauri",
                    14 => "W Wolf–Rayet",
                    13 => "Y cool brown dwarf"];

        if($sort)
            return $sortArray;

        else
            return $array;
    }

    public static function planetTypeArray() {
        switch(\App::getLocale())
        {
            case 'ru':
                return ['Т-металлик', 'Т-водные', 'Т-каменистые', 'Землеподобные', 'Водные', 'Аммиачные'];
            default:
                return ['T-high metal',
                            'T-water world',
                            'T-rocky world',
                            'Earth-likes',
                            'Water worlds',
                            'Ammonia worlds'];
        }
    }

    public static function planetsForCabinet(){
        return ['T-HM', 'T-WW', 'T-RW', 'EL', 'WW', 'AW'];
    }

    public static function sizeTypeArray() {
        return ['0', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII'];
    }

    public static function stopList() {
        return [5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18];
    }

    public static function colorList() {
        switch(\App::getLocale()) {
            case 'ru':
                return ['Т-металлик'=>'rgb(255, 107, 1)',
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
                    'водные всех типов'=>'rgb(0,0,255)',
                    'земные'=>'rgb(0, 132, 0)'];
            default:
                return ['T-high metal' => 'rgb(255, 107, 1)',
                    'T-water world' => 'rgb(0, 209, 242)',
                    'T-rocky world' => 'rgb(163, 82, 0)',
                    'Earth-likes' => 'rgb(0, 132, 0)',
                    'Water worlds' => 'rgb(119, 152, 191)',
                    'Ammonia worlds' => 'rgb(102, 51, 0)',
                    'M' => 'rgb(255, 107, 1)',
                    'K' => 'rgb(255, 204, 0)',
                    'G' => 'rgb(255, 255, 0)',
                    'F' => 'rgb(255, 255, 153)',
                    'A' => 'rgb(240, 255, 255)',
                    'редкие' => 'rgb(204, 153, 255)',
                    'аммиачные' => 'rgb(102, 51, 0)',
                    'водные не пригодные к ТФ' => 'rgb(119, 152, 191)',
                    'пригодные к ТФ без земных' => 'rgb(0, 255, 255)',
                    'Earth-likes and TF suitable' => 'rgb(102, 255, 153)',
                    'water worlds of all types' => 'rgb(0,0,255)',
                    'Earth-likes planets' => 'rgb(0, 132, 0)'];
        }
    }

    public static function rankList() {
        switch(\App::getLocale())
        {
            case 'ru':
                return ['Новичок',
                    'Почти новичок',
                    'Разведчик',
                    'Инспектор',
                    'Пионер',
                    'Следопыт',
                    'Рейнджер',
                    'Первопроходец',
                    'Элита'];
            default:
                return ['Aimless',
                    'Mostly-Aimless',
                    'Scout',
                    'Surveyor',
                    'Trailblazer',
                    'Pathfinder',
                    'Ranger',
                    'Pioneer',
                    'Elite'];
        }

    }
    public static function rankLogo() {
        return ['Aimless.png',
            'Mostly-Aimless.png',
            'Scout.png',
            'Surveyor.png',
            'Trailblazer.png',
            'Pathfinder.png',
            'Ranger.png',
            'Pioneer.png',
            'Elite.png'];

    }

    public static function moderationMarks(){
        switch(\App::getLocale())
        {
            case 'ru':
                return ['danger'=>'превышение зоны распределения', 'warning'=>'слишком мало соседей'];
            default:
                return ['danger'=>'Excesses spreading zone', 'warning'=>'Not sufficient neighbours'];
        }
    }
    public static function cabinetRouts()
    {
        switch(\App::getLocale())
        {
            case 'ru':
                return ['cabinet'=>'Статистика', 'discovery'=>'Журнал систем', 'cabinetSearch' => 'Поиск', 'usermail'=>'Почта', 'totalStats'=>'Рейтинг'];
            default:
                return ['cabinet'=>'Statistics', 'discovery'=>'Discovery log', 'cabinetSearch' => 'Search', 'usermail'=>'Mail', 'totalStats'=>'Pilot rating'];
        }
    }
    public static function adminRouts(){
        switch(\App::getLocale())
        {
            case 'ru':
                return ['administration'=>'Системы на модерацию', 'adminmail'=>'Почта', 'search'=>'Поиск по базе'];
            default:
                return ['administration'=>'For moderation', 'adminmail'=>'Mail', 'search'=>'Advanced Search'];
        }
    }
    public static function moderRouts(){
        switch(\App::getLocale())
        {
            case 'ru':
                return ['moderation'=>'Главная',
                    'recent'=>'Особые регионы',
                    'reader'=>'Пакетный ввод',
                    'roles'=>'Доступ пользователей',
                    'texts'=>'Тексты на сайт',
                    'multi'=>'Многозвездные системы'];
            default:
                return ['moderation'=>'Main',
                    'recent'=>'Regions',
                    'reader'=>'Downloads',
                    'roles'=>'Users',
                    'texts'=>'Texts',
                    'multi'=>'Multistars'];
        }
    }

    public static function nameStar(\App\Star $star)
    {
        $starName=self::allStarsArray();
        $sizeName=self::sizeTypeArray();

        if($star->star == 15 || $star->star==16) {
            return $starName[$star->star];
        }
        else {
            return $starName[$star->star].$star->class." ".$sizeName[$star->size];
        }
    }


    public static function translate($locale)
    {
        $en=[
                'Т-металлик'=>'T-high metal',
                'Т-водные'=>'T-water world',
                'Т-каменистые'=>'T-rocky world',
                'Землеподобные'=>'Earth-likes',
                'Водные'=>'Water worlds',
                'Аммиачные'=>'Ammonia worlds'];
        $ru=[
            'T-high metal'=>'Т-металлик',
            'T-water world'=>'Т-водные',
            'T-rocky world'=>'Т-каменистые',
            'Earth-likes'=>'Землеподобные',
            'Water worlds'=>'Водные',
            'Ammonia worlds'=>'Аммиачные'];

        switch($locale)
        {
            case 'ru':
                return $ru;
            case 'en':
                return $en;
        }
    }

    public static function chartNav()
    {
        switch(\App::getLocale())
        {
            case 'ru':
                return ['Общие данные', 'Функциональные графики', 'Круговые диаграммы', 'Точечный график'];
            default:
                return ['Common data', 'Functional charts', 'Pie charts', 'Dotted charts'];
        }
    }

    public static function mailNavNames()
    {
        switch(\App::getLocale())
        {
            case 'ru':
                return ['inbox'=>'Входящие', 'sent'=>'Исходящие', 'new'=>'Новое письмо'];
            default:
                return ['inbox'=>'Inbox', 'sent'=>'Sent', 'new'=>'New letter'];
        }
    }

    public static function mailNav($folder)
    {
        $name_num=['inbox'=>0, 'sent'=>1, 'new'=>2];
        $num_name=['inbox', 'sent', 'new'];
        $names = self::mailNavNames();

        $currentN = $name_num[$folder];
        $left = $currentN - 1;
        $right = $currentN + 1;
        if($left < 0) $left = 2;
        if ($right > 2) $right = 0;

        $result['current']=$names[$folder];
        $result['left']=$num_name[$left];
        $result['right']=$num_name[$right];

        return $result;
    }


    public static function prepareNavigation($total, $current)
    {
        $left = $current - 1;
        $right = $current + 1;
        if ($left < 0)
            $left = $total - 1;
        if ($right > $total - 1)
            $right = 0;
        return ['left'=>$left, 'right'=>$right];
    }

    public static function atmosphereType()
    {
        switch(\App::getLocale())
        {
            case 'ru':
                return ['без атмосферы',
                        'аммиак',
                        'аммиак и кислород',
                        'азот',
                        'вода',
                        'высокое содержание аммиака',
                        'высокое содержание аргона',
                        'высокое содержание воды',
                        'высокое содержание диоксида углерода',
                        'высокое содержание метана',
                        'гелий',
                        'диоксид серы',
                        'диоксид углерода',
                        'кислород',
                        'металлические пары',
                        'подходит для жизни на основе воды',
                        'силикатные пары'];
            default:
                return ['no atmosphere',
                        'ammonia',
                        'ammonia and oxygen',
                        'nitrogen',
                        'water',
                        'ammonia-rich',
                        'argon-rich',
                        'water-rich',
                        'carbon dioxide-rich',
                        'methane-rich',
                        'helium',
                        'sulphur dioxide',
                        'carbon dioxide',
                        'oxygen',
                        'metallic vapour',
                        'suitable for water based life',
                        'silicate vapour'];
        }
    }

    public static function atmosphereComposition()
    {
        switch(\App::getLocale())
        {
            case 'ru':
                return ['amm'=>'аммиак',
                    'oxy'=>'кислород',
                    'nit'=>'азот',
                    'arg'=>'аргон',
                    'hel'=>'гелий',
                    'wat'=>'вода',
                    'hyd'=>'водород',
                    'sud'=>'диоксид серы',
                    'cad'=>'диоксид углерода',
                    'irn'=>'железо',
                    'met'=>'метан',
                    'neo'=>'неон',
                    'sil'=>'силикаты'];
            default:
                return ['amm'=>'ammonia',
                    'oxy'=>'oxygen',
                    'nit'=>'nitrogen',
                    'arg'=>'argon',
                    'hel'=>'helium',
                    'wat'=>'water',
                    'hyd'=>'hydrogen',
                    'sud'=>'sulphur doixide',
                    'cad'=>'carbon dioxide',
                    'irn'=>'iron',
                    'met'=>'methane',
                    'neo'=>'neon',
                    'sil'=>'silicates'];
        }
    }

    public static function planetComposition()
    {
        switch(\App::getLocale())
        {
            case 'ru':
                return ['ice'=>'лед', 'rock'=>'камень', 'metal'=>'металл'];
            default:
                return ['ice'=>'ice', 'rock'=>'rock', 'metal'=>'metal'];
        }
    }

    public static function volcanism()
    {
        switch(\App::getLocale())
        {
            case 'ru':
                return ['без вулканизма',
                        'гейзеры с силикатными парами',
                        'железная магма',
                        'водяная магма',
                        'силикатная магма',
                        'углекислотные гейзеры',
                        'водяные гейзеры'];
            default:
                return ['no volcanism',
                        'silicate vapour geysers',
                        'iron magma',
                        'water magma',
                        'silicate magma',
                        'carbon dioxide geysers',
                        'water geysers'];
        }
    }

    public static function commonExtraNames()
    {
        switch(\App::getLocale())
        {
            case 'ru':
                return ['mass'=>'земных масс: ',
                    'radius'=>'радиус, км:',
                    'temperature'=>'температура поверхности, K: ',
                    'pressure'=>'давление у поверхности, атмосфер: ',
                    'volcanism'=>'вулканизм: ',
                    'atm_type'=>'тип атмосферы: ',
                    'price'=>'цена в кредитах: '];
            default:
                return ['mass'=>'mass, earth masses: ',
                    'radius'=>'radius, km: ',
                    'temperature'=>'surface temperature, K: ',
                    'pressure'=>'surface pressure, atm: ',
                    'volcanism'=>'volcanism: ',
                    'atm_type'=>'atmosphere type:',
                    'price'=>'price, credits:'];
        }
    }

    public static function orbitExtraNames()
    {
        switch(\App::getLocale())
        {
            case 'ru':
                return ['orbP'=>'Сидерический период обращения, дн: ',
                        'mAxis'=>'Большая полуось: а.е.: ',
                        'ecce'=>'Эксцентриситет орбиты: ',
                        'incl'=>'наклонение орбиты, град: ',
                        'peri'=>'Аргумент перицентра, град:',
                        'rotP'=>'Период обращения, дн: ',
                        'aTilt'=>'Наклон оси вращения, град: ',
                        'locked'=>'Приливный захват'];
            default:
                return ['orbP'=>'Orbital period, D: ',
                        'mAxis'=>'Semi major axis, AU: ',
                        'ecce'=>'Orbital eccentricity: ',
                        'incl'=>'Orbital inclination, deg: ',
                        'peri'=>'Arg of periapsis, deg: ',
                        'rotP'=>'Rotational period, D: ',
                        'aTilt'=>'Axial tilt, deg: ',
                        'locked'=>'Tidally locked'];
        }
    }

    public static function starParams()
    {
        switch(\App::getLocale())
        {
            case 'ru':
                return ['age'=>'Возраст, миллионы лет:',
                        'smass'=>'Масса, в массах Солнца:',
                        'srad'=>'Радиус в радиусах Солнца:',
                        'temperature'=>'Температура, K'];
            default:
                return ['age'=>'Age, million years:',
                        'smass'=>'Solar masses:',
                        'srad'=>'Solar radius:',
                        'temperature'=>'Temperature, K:'];
        }
    }


}