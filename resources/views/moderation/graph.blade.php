<script>
    $(function () {
        $('#chartdiv').highcharts({
            chart: {
                type: 'scatter',
                zoomType: 'xy'
            },
            title: {
                text: '{{$name}}'
            },
            xAxis: {
                title: {
                    enabled: true,
                    text: 'Цена'
                },
                startOnTick: true,
                endOnTick: true,
                showLastLabel: true
            },
            yAxis: {
                title: {
                    text: '{{$axis}}'
                }
                @if(count($axisNames) > 0),
                categories: [
                    @foreach($axisNames as $one)
                    '{{$one}}',
                    @endforeach
                   ]
                @endif
        },
            plotOptions: {
                scatter: {
                    marker: {
                        radius: 5,
                        states: {
                            hover: {
                                enabled: true,
                                lineColor: 'rgb(100,100,100)'
                            }
                        }
                    },
                    states: {
                        hover: {
                            marker: {
                                enabled: false
                            }
                        }
                    },
                    tooltip: {
                        headerFormat: '<b>{series.name}</b><br>',
                        pointFormat: '{point.x} cr, {point.y} {{$axis}}'
                    }
                }
            },
            series: [{
                name: 'Планета',
                color: 'rgba(223, 83, 83, .5)',
                data: [
                    @foreach ($array as $one)
                    [{{$one['price']}}, {{$one['param']}}],
                    @endforeach
                    ]

            }]
        });
    });
</script>
<div id="chartdiv"></div>