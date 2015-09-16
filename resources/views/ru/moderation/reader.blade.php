@extends('app')
@section('content')
    @if (count($errors) > 0)
        @include('errors.display')
    @endif
<h3>Форма для загрузки файлов отчетов</h3>
<p>Для стабильной работы скрипта необходимо чтобы в имени файла не использовалась кириллица, а так же файл имел расширение txt.</p>
<p>Формат данных, принимаемый программой:</p>
<b class="white">IC_1805_Sector ZO-H_c10-7 G4 V T_H-M 0,81</b>
<h3>Структура строки:</h3>
<p>Для верного распознавания данных строка делится на блоки. Блоки между собой разделяются пробелами. Внутри блока пробелы <strong style="color:red;">ЗАПРЕЩЕНЫ</strong>! Вместо него используется символ нижнего подчеркивания_.</p>
<p>На каждой строке файла должна быть инфромация только по одной планете в принимаемом программой формате.</p>
<p><span class="white">КОД_РЕГИОНА</span> <i>кода может не быть, тогда сразу имя звезды по тем же правилам</i></p>
<p><span class="white">КОД_В_РЕГИОНЕ</span></p>
<p><span class="white">ЗВЕЗДА+температура</span> <i>у определенных типов звезд N, BH нет данных по температуре и размеру. Их можно опустить в этом случае.</i></p>
<p><span class="white">РАЗМЕР</span> <i>Только размер без дополнительных параметров. Т.е. V, VII, III</i></p>
<p><span class="white">ПЛАНЕТА</span> <i>Допустимые обозначения: T_H-M, T_WW, WW, AW, E_L, T_RW</i></p>
<p><span class="white">МАРКЕР</span><i>Необходим, если планета находится в бинарной и более паре. По умолчанию не требуется. Допустимые значения: bin, tri, qua, sat</i></p>
<p><span class="white">РАССТОЯНИЕ</span> <i>Для обозначения десятичной дроби допустимо использовать как запятую, так и точку</i></p>
<p>После обработки скрипт выведет непринятые системы с объяснением. Необходимо исправить ошибки, записать данные в новый файл и загрузить их заново. Во избежания возможного внесения одинаковых данных (возможного в ряде случаев) не рекомендуется исправлять старый файл и загружать его заново с уже одобренными объектами.</p>
<form action="{{route('reportAccepter')}}" method="post" enctype="multipart/form-data">
    <input type="hidden" value="{{csrf_token()}}" name="_token">
    <input type="file" name="filename"><br>
    <input type="submit" value="Загрузить"><br>
</form>
    @stop