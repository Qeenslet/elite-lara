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
                text: 'Статистика по звезде {{$chart->starHeader}} {{$chart->tempHeader}} {{$chart->sizeHeader}}. Планеты: {{$chart->inHeader}}'
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
                    text: 'Количество'
                }
            },
            tooltip: {
                headerFormat: '<b>{series.name}</b><br/>',
                pointFormat: '{point.x} а.е.: {point.y} шт.'
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
<p>На графике можно включать и отключать данные по разным типам планет. Для этого нужно кликнуть по символу выборки в легенде.</p>