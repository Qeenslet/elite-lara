<script>
    $(function () {
        $('#chartdiv').highcharts({
            chart: {
                type: 'spline'
            },
            credits: {
                enabled: false
            },
            title: {
                text: 'Statistics about the star {{$chart->starHeader}} {{$chart->tempHeader}} {{$chart->sizeHeader}}. Planets: {{$chart->inHeader}}'
            },
            xAxis: {
                labels: {
                    formatter: function(){
                        return this.value + 'а.е.';
                    }
                }
            },
            yAxis: {
                title: {
                    text: 'Amount'
                }
            },
            tooltip: {
                headerFormat: '<b>{series.name}</b><br/>',
                pointFormat: '{point.x} AU: {point.y} pieces'
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },
            series: [
                       @foreach ($chart->result as $key=>$value)
                                {
                                name: '{{$chart->planetTypeArray[$key]}}',
                                color: '{{$colors[$chart->planetTypeArray[$key]]}}',
                                data: [
                                @foreach ($value as $dist=>$number)
                                    [{{$dist}}, {{$number}}],
                                @endforeach
                                ]
                                },
                       @endforeach

            ]
        });
    });
</script>
<div id='chartdiv'></div>
<p>You can turn on and off different series in the chart. Just click it's name in the legend.</p>