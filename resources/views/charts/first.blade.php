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
                    formatter: function () {
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
            series: [{
                name: 'количество: {{$chart->inHeader}}',
                color: '{{$colors[$chart->inHeader]}}',
                data: [
                    @foreach ($chart->result as $key=>$value)
                    [{{$key}}, {{$value}}],
                    @endforeach
                    ]
            }]
        });
    });
</script>
<div id='chartdiv'></div>