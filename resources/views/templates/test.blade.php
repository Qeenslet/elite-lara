@extends('elite')
@section('title')
    Working with database|@parent
@stop
@section('content')
    @if (count($errors) > 0)
        @include('errors.display')
    @endif

    @if(isset($result))
        @if($result=='ok')
            @include('responses.success')
        @endif
        @if($result=='moder')
            @include('responses.moderation')
        @endif
        @if($result=='fail')
            @include('responses.dbfail')
        @endif
        @if($result=='sameStar')
            @include('responses.sameStar')
        @endif
        @if($result=='samePlanet')
            @include('responses.samePlanet')
        @endif
        @if($result=='sameBary')
            @include('responses.sameBary')
        @endif
    @endif
    <h2 class="inside_headers_white">Working with database</h2>
    @if(isset($welcome))
    <div class="panel-cabinet" id="localAbout">
        <div style="margin: 5px; width:100%; height: 10%; position: relative; top:1px;"><a href="javascript:closeInfo();" class="info-close-btn"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></div>
        <br>
        <p>Hi, <span class="white">{{Auth::user()->name}}</span>! Welcome to the main page for our database. Here you can search for data about the systems in our database or you can add data about stars and planets you've discovered during your journeys.</p>
        <p>In order to add a new system, add the region's name in the first field, and then the systems code, which is the random looking alphanumeric text after the region name.
            Systems with names from catalogs like HIP, HD, HR are entered using the same scheme. The catalog name is <span class="white">the region name</span>, and the digital code or number is placed in the field <span class="white">code</span>.</p>
        <p>To add the star's that has a personal name which is not the catalog code but something like a constellation plus number or other type of name press the button 'named star' to enter it.</p>
    </div>
    @endif
    <hr>
    <form method="get" action="{{route('searchadd')}}" class="form-inline">

        <div class="form-group">
            <label for="region">System name:</label>
            <input type="text"
                   class="form_add_1 largeSelect"
                   id="region"
                   name="address">
        </div>
        <button type="submit" class="btn btn-warning"><span class="glyphicon glyphicon-search"></span> Search</button>
    </form>
    <hr>
        <button class="btn btn-success" id="addNew"><span class="glyphicon glyphicon-plus"></span> New system</button>
    @if(isset($systemDs))
        @foreach($systemDs as $systemD)
            <h3>{{$systemD->getSystemName()}}</h3>
            @if(!$systemD->getAllCenters())
               <h4>Система пуста!</h4>
            @else
                <table class="panel-cabinet">
                    @foreach($systemD->getAllCenters() as $center)
                        <tr>
                            <td style="width: 40%">
                                @foreach ($systemD->getOneCenter($center) as $centerObject)
                                    <div class="panel-cabinet pointed starsS" data="_token={{csrf_token()}}&type={{$centerObject['type']}}&id={{$centerObject['id']}}">
                                        <img src="/media/stars/{{$centerObject['image']}}"> {{$centerObject['name']}}
                                    </div>
                                @endforeach
                            </td>
                            <td style="width: 40%">
                                @foreach($systemD->getCenterPlanets($center) as $id=>$planet)
                                    <div class="panel-cabinet pointed planetsS" data="_token={{csrf_token()}}&type={{$planet['type']}}&id={{$id}}">
                                        <img src="/media/planets/{{$planet['image']}}"> {{$planet['name']}}<br>
                                    </div>
                                @endforeach
                            </td>
                            <td>
                                <button class="btn btn-warning addNewPlanet" data="addr_id={{$systemD->getAddrId()}}&id={{$systemD->getCenterId($center)}}&type={{$systemD->getType($center)}}">
                                    <span class="glyphicon glyphicon-plus"></span>
                                    New planet</button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
            <button class="btn btn-danger" id="addNewStar" data="id={{$systemD->getAddrId()}}"><span class="glyphicon glyphicon-plus"></span> New star</button>
            @if(count($systemD->getAllCenters())>1)
                <button class="btn btn-primary" id="addBarycenter" data="id={{$systemD->getAddrId()}}"><span class="glyphicon glyphicon-plus"></span> New barycenter</button>
            @endif
        @endforeach
    @endif
@stop
@section('scripts')
    @parent
    <script type="text/javascript" src="/js/newBaseAdder.js"></script>
    <script>
        setTimeout(function(){
            $('#result-response').fadeOut(1000);
            $('#form-error').fadeOut(1000);
        },5000);
        @if(isset($nothing))
            alert('Nothing has been found!');
        @endif

        function closeInfo()
        {
            $('#localAbout').slideUp(300);
        }
    </script>
@stop