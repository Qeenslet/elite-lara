<script>
    $(function () {

        $(document).ready(function () {

            // Build the chart
            $('#chartdiv').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                },
                credits: {
                    enabled: false
                },
                title: {
                    text: 'All planets in the database'
                },
                tooltip: {
                    pointFormat: '<b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Planets statistics',
                    data: [
                            @foreach($charter->result as $key=>$value)
                        {name: '{{$key}}',
                        y: {{$value}},
                        color: '{{$colors[$key]}}'},
                            @endforeach
                    ]
                }]
            });
        });

    });
</script>
<div id='chartdiv'></div>