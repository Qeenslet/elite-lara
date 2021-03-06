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
                text: 'Statistics about {{$chart->starHeader}} {{$chart->tempHeader}} {{$chart->sizeHeader}} type stars. Planets: {{$chart->inHeader}}'
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
                    text: 'Amount'
                }
            },
            tooltip: {
                headerFormat: '<b>{series.name}</b><br/>',
                pointFormat: '{point.x} AU: {point.y} pieces.'
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
                name: 'amount: {{$chart->inHeader}}',
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