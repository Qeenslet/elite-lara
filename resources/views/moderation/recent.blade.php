@extends('app')
@section('content')
    <table class="table table-striped">
        <thead>
        <tr>
            <th>
                Адрес
            </th>
            <th>
                Объекты
            </th>
            <th>
                Пилот
            </th>
        </tr>
        <thead>
        <tbody>
        @foreach($address as $key=>$id)
            <?php $content=new \App\Myclasses\starSystemInfo($id); ?>
            <tr>
                <td>
                    {{$content->fName}}
                </td>
                <td>
                    @foreach($content->starsIn as $num=>$value)
                        Звезда: {{$value}} <br>
                        Планеты:<br>
                        @foreach($content->planetsIn[$num] as $planet)
                            {{$planet}} <br>
                        @endforeach
                    @endforeach
                </td>
                <td>
                    {{$pilots[$key]}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop