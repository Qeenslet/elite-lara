@extends('cabinet.cabinetMain')
@section('title')
    Search|@parent
@stop
@section('local')
    <h2>Search for system data in your log</h2>
    <hr>
    <form method="get" action="{{route('cabinetSearch')}}" class="form-inline">
        <div class="form-group">
            <label for="star_select">Star type</label>
            <select id="star_select" name="star">
                @foreach ($arr=\App\Myclasses\Arrays::allStarsArray(true) as $num => $one)
                    <option value="{{$num}}">{{$one}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="planet_select">Planet</label>
            <select id="planet_select" name="planet">
                @foreach(\App\Myclasses\Arrays::planetsForCabinet() as $key=>$value)
                    <option value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-warning">Search</button>
    </form>
    <hr>

    @if(isset($systemDs))
        <?php
        $iterTotal=1;
        $iterLocal=-9;
        ?>
        @foreach($systemDs as $systemD)
            @if($iterLocal==1)
                <a href="javascript:showMore({{$iterTotal}})" class="btn btn-primary" id="btn{{$iterTotal}}"
                @if($iterTotal>11)
                   style="display:none"
                        @endif>Еще {{count($systemDs)+1-$iterTotal}}</a>
                <article id="ammount{{$iterTotal}}" style="display:none">
                    @endif
                    <h3><a href="javascript:rolldown('{{$systemD->getAddrId()}}')">{{$systemD->getSystemName()}}</a></h3>
                    <div id="addr_{{$systemD->getAddrId()}}" style="display:none;">
                        <div class="row panel-cabinet" style="margin: 10px;">
                            @if(!$systemD->getAllCenters())
                                <h4>System is empty!</h4>
                            @else
                                <table style="width: 100%">
                                    @foreach($systemD->getAllCenters() as $center)
                                        <tr>
                                            <td style="width: 40%">
                                                @foreach ($systemD->getOneCenter($center) as $centerObject)
                                                    <div class="panel-cabinet extra"
                                                    @if(isset($centerObject['extra']))
                                                         data-tooltip="@include('interface.starInsides')"
                                                         @else
                                                         data-tooltip="<h4>No object data available!</h4>"
                                                         @endif
                                                         data="_token={{csrf_token()}}&type={{$centerObject['type']}}&id={{$centerObject['id']}}">
                                                        <img src="/media/stars/{{$centerObject['image']}}"> {{$centerObject['name']}}
                                                    </div>
                                                @endforeach
                                            </td>
                                            <td style="width: 60%">
                                                @foreach($systemD->getCenterPlanets($center) as $id=>$planet)
                                                    <div class="panel-cabinet extra"
                                                    @if (isset($planet['extra']))
                                                         data-tooltip="@include('interface.planetInsides')"
                                                         @else
                                                         data-tooltip="<h4>No object data available!</h4>"
                                                         @endif
                                                         data="_token={{csrf_token()}}&type={{$planet['type']}}&id={{$id}}">
                                                        <img src="/media/planets/{{$planet['image']}}"> {{$planet['name']}}<br>
                                                    </div>
                                                @endforeach
                                            </td>


                                    @endforeach
                                </table>
                            @endif
                        </div>
                    </div>
                    @if($iterLocal==10)
                </article>
                <?php $iterLocal=0; ?>
            @endif
            <?php $iterTotal++;
            $iterLocal++;?>
        @endforeach
    @endif
    @if(isset($nothing))
        <script>
            alert('{{$nothing}}')
        </script>
    @endif
    @if(isset($selRep))
        <script>
            alert('{{$selRep}}')
        </script>
    @endif
@stop
@section('scripts')
    @parent
    <script type="text/javascript" src="/js/showTooltip.js"></script>
    <script>
        function rolldown(id)
        {
            $('#addr_'+id).slideToggle();
        }
        function showMore(id)
        {
            $('#ammount'+id).slideDown();
            $('#btn'+id).hide();
            var next=id+10;
            $('#btn'+next).show();
        }
    </script>
@stop