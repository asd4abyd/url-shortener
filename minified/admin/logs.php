<?php include_once('layout/header.php'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">IPs</h3></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table">
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="tab">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Link</th>
                                    <th>OS</th>
                                    <th>Browser</th>
                                    <th>Referrer</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.9/datatables.min.js"></script>
<script>
//    $(document).ready(function() {
        $('#tab').dataTable({
            "ajax":  {
                "url": "getLog.php?ip=<?=$_GET['ip'] ?>",
                "type": "POST"
            },
            "processing": true,
            "aaSorting": [],
            "serverSide": true,

            "columns": [
                { "data": "l_con" },
                { "data": "link" },
                { "data": "os" },
                { "data": "browser" },
                { "data": "referrer" }]
        });
//    });
</script>
<?php include_once('layout/footer.php'); ?>