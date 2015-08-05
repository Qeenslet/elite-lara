@extends('app')
@section('top-style')
    @parent
    <script src="{{ asset('/ammap/ammap.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" href="{{ asset('/ammap/ammap.css') }}" type="text/css" media="all" />
    <script src="/ammap/maps/js/worldLow.js" type="text/javascript"></script>
@stop
@section('content')

    <div id="mapdiv" style="width: 1000px; height: 666px;"></div>
@stop
@section('scripts')
    @parent
    <script>
        AmCharts.ready(function() {
            // create AmMap object
            var map = new AmCharts.AmMap();
            // set path to images
            map.pathToImages = "/ammap/images/";

            /* create data provider object
             map property is usually the same as the name of the map file.

             getAreasFromMap indicates that amMap should read all the areas available
             in the map data and treat them as they are included in your data provider.
             in case you don't set it to true, all the areas except listed in data
             provider will be treated as unlisted.
             */
            var dataProvider = {
                map: "worldLow",
                areas:[{id:"AU"},{id:"US"},{id:"FR"}],
                images:[{latitude:40.3951, longitude:-73.5619, type:"circle", color:"#6c00ff", scale:0.5, label:"New York", labelShiftY:2, title:"New York", description:"New York is the most populous city in the United States and the center of the New York Metropolitan Area, one of the most populous metropolitan areas in the world."}]
            };
            // pass data provider to the map object
            map.dataProvider = dataProvider;

            /* create areas settings
             * autoZoom set to true means that the map will zoom-in when clicked on the area
             * selectedColor indicates color of the clicked area.
             */
            map.areasSettings = {
                autoZoom: true,
                selectedColor: "#CC0000"
            };

            // let's say we want a small map to be displayed, so let's create it
            map.smallMap = new AmCharts.SmallMap();

            // write the map to container div
            map.write("mapdiv");
        });
    </script>
 @stop