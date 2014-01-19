<?php
require_once('../../includes/session_timeout_db.inc.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Tangra Gaming User Statistics</title>
        <link rel="stylesheet" type="text/css" href="../../style.css" />
        <script type="text/javascript" src="../../js/jquery-1.7.1.min.js" ></script>
        <script type="text/javascript" src="../../js/Highcharts-3.0.7/js/highcharts.js" ></script>
        <script type="text/javascript" src="../../js/Highcharts-3.0.7/js/themes/gray.js"></script>
        <script type="text/javascript">
            var chart;
            $(document).ready(function() {
                var options = {
                    chart: {
                        renderTo: 'container',
                        defaultSeriesType: 'line',
                        marginRight: 130,
                        marginBottom: 25
                    },
                    title: {
                        text: 'Daily User Created',
                        x: -20 //center
                    },
                    subtitle: {
                        text: '',
                        x: -20
                    },
                    xAxis: {
                        type: 'datetime',
                        tickInterval: 3600 * 24000, // one day
                        tickWidth: 0,
                        gridLineWidth: 1,
                        labels: {
                            align: 'center',
                            x: -3,
                            y: 20,
                            formatter: function() {
                                return Highcharts.dateFormat('%l%p', this.value);
                            }
                        }
                    },
                    yAxis: {
                        title: {
                            text: 'Users'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }]
                    },
                    tooltip: {
                        formatter: function() {
                            return Highcharts.dateFormat('%l%p', this.x - (24000 * 3600)) + '-' + Highcharts.dateFormat('%l%p', this.x) + ': <b>' + this.y + '</b>';
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: -10,
                        y: 100,
                        borderWidth: 0
                    },
                    series: [{
                            name: 'Count'
                        }]
                }
                // Load data asynchronously using jQuery. On success, add the data
                // to the options and initiate the chart.
                // This data is obtained by exporting a GA custom report to TSV.
                // http://api.jquery.com/jQueryin/statistics/daily_users_created.inc.php.get/
                jQuery.get('../../includes/admin/statistics/daily_users_created.inc.php', null, function(tsv) {
                    var lines = [];
                    traffic = [];
                    try {
                        // split the data return into lines and parse them
                        tsv = tsv.split(/\n/g);
                        jQuery.each(tsv, function(i, line) {
                            line = line.split(/\t/);
                            date = Date.parse(line[0] + ' UTC');
                            traffic.push([
                                date,
                                parseInt(line[1].replace(',', ''), 10)
                            ]);
                        });
                    } catch (e) {
                    }
                    options.series[0].data = traffic;
                    chart = new Highcharts.Chart(options);
                });
            });
        </script>
    </head>

    <body>

        <div id="allcontent">

            <div id="header">
                <img src="../../images/banner.png" alt="Tangra Gaming"/>
            </div>

            <div id="cssmenu">
<?php include('../../includes/menu.inc.php'); ?>
            </div>

            <div id="maincontent">
                <h1>
                    View User Statistics
                </h1>

            </div>
            <div id="container" style="width: 100%; height: 400px; margin: 0 auto"></div>

            <div id="footer">
<?php include('../../includes/footer.inc.php'); ?>
            </div>

        </div>

    </body>
</html>