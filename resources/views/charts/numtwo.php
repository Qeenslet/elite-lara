<script>
    $(function () {

        $('#chartdiv').highcharts({
            chart: {
                type: 'pie',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            credits: {
                enabled: false
            },
            title: {
                text: '<?=$chart->title; ?>'
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
                    }
                }
            },

            series: [{
                type: 'pie',
                name: 'By star types',
                data: [
                    <?php foreach ($chart->d_1 as $key => $value) {
                    if (array_key_exists($key, $chart->d_2))
                    {
                    if ($key=='редкие') echo "{name: 'Rare star types', y: $value, drilldown: '$key', color: '$colors[$key]'},";
                    else echo "{name: '$key stars', y: $value, drilldown: '$key', color: '$colors[$key]'},";
                    }
                    else echo "['$key stars', $value],";
                    }?>]
            }],
            drilldown: {
                activeDataLabelStyle: {
                    cursor: 'pointer',
                    color: '#F0F0F3',
                    fontWeight: 'italic',
                    textDecoration: 'none'
                },

                series: [
                    <?php
                    foreach ($chart->d_1 as $key=> $value) {
                        echo"{";
                        echo "id: '$key', ";
                        echo "name: 'By sizes',";
                        echo "data: [";
                        foreach ($chart->d_2[$key] as $estrella => $cantidad) {
                            if($key=='редкие')
                            {
                                echo "['$estrella stars', $cantidad],";
                                continue;
                            }
                            if ($chart->d_3[$key][$estrella])
                            {
                                $mark = $key." ".$estrella;
                                $drill_3[]=$mark;
                                echo "{name: '$mark stars', y: $cantidad, drilldown: '$mark'},";
                            }
                            else echo "['$estrella stars', $cantidad],";
                        }
                        echo "]";
                        echo "},";
                    }
                    foreach ($drill_3 as $key) {
                        $key_one = substr($key, 0, 1);
                        $key_two = substr($key, 2);
                        echo "{";
                        echo "id: '$key',";
                        echo "name: 'By class',";
                        echo "data: [";
                        foreach ($chart->d_3[$key_one][$key_two] as $name => $cant) {
                            $name_chart = $name.$key_two;
                            echo "['$name_chart stars', $cant],";
                        }
                        echo "]";
                        echo "},";
                    }
                    ?>
                ]
            }
        });
    });
</script>
<div id='chartdiv'></div>