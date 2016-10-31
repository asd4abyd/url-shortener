<?php include_once('layout/header.php'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Hits Per Day Within a Week</h3></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div>
                            <div id="chart1" style="height: 250px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Users Type</h3></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div>
                            <div id="chart2" style="height: 250px;"></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div>
                            <div id="chart3" style="height: 250px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Users Type</h3></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div>
                            <div id="chart4" style="height: 250px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>var resizefunc = [];</script>
<script>

    $.get('data/getDataForChartBar.php')
        .success(function(data) {
            data.element = 'chart1';
            new Morris.Bar(data);
        });

    $.get('data/getDataForChartDonut.php')
        .success(function(data) {
            data.element = 'chart2';
            new Morris.Donut(data);
        });

    $.get('data/getDataForChartDonutBrowser.php')
        .success(function(data) {
            data.element = 'chart3';
            new Morris.Donut(data);
        });

    $.get('data/getDataForChartLine.php')
        .success(function(data) {
            data.data.element = 'chart4';
            data.data.parseTime = false;
            data.data.xLabelFormat= function(data1){
                var arr = data.os;
                return arr[data1.label];
            };

            new Morris.Line(data.data);
        });

</script>
<?php include_once('layout/footer.php'); ?>