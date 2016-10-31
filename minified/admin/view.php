<?php
    $status = isset($_POST['status'])? $_POST['status']: "";
    $ip     = isset($_POST['ip'])? $_POST['ip']: "";

    if(!($status=='' or $ip=='')) {
        require_once('_additional.php');


        $db = new mysqli($db_host, $db_user, $db_pass, $db_base);
        if ($db->connect_errno) {
            //echo "Unable to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
            die('Database Not Connected');
        }

        $db->query("insert into bots_ip (`ip`, `admin_status`) value ('$ip', '$status') ON DUPLICATE KEY UPDATE `admin_status` = VALUES(`admin_status`);");

    }

    include_once('layout/header.php');

?>
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
                                    <th>IP</th>
                                    <th>Last Request</th>
                                    <th>Status</th>
                                    <th>Admin Permission</th>
                                    <th>Count Of Hits</th>
                                    <th>Action</th>
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
    $(document).ready(function() {
        var tbl = $('#tab').DataTable({
            "ajax":  {
                "url": "getData.php",
                "type": "POST"
            },
            "processing": true,
            "aaSorting": [[1,'desc'], [4,'desc']],
            "serverSide": true,
            "columns": [
                { "data": "ip" },
                { "data": "l_con" },
                { "data": "b" },
                { "data": "admin_b" },
                { "data": "hits" },
                { "data": "action" }
            ],
            "aoColumnDefs": [
                {
                    "aTargets": [0],
                    "mRender": function (data, type, full) {
                        if (data) {
                            return "<a href='logs.php?ip="+data+"'>"+ data +"</a>";
                        }
                        return "";
                    }
                },

                {
                    "aTargets": 5,
                    "data": null,
                    "defaultContent": "<button class='btn-allow'>allow</button>  <button class='btn-block'>Block</button>  <button class='btn-none'>None</button>"
                }
            ],
            "fnDrawCallback" : function() {
                $('.btn-allow').click(function() {

                    var ip = $(this).parent().parent().find('td a').text();

                    $.get('setAllow.php', {'ip': ip})
                        .success(reloadTbl);

                });

                $('.btn-block').click(function() {

                    var ip = $(this).parent().parent().find('td a').text();

                    $.get('setBlock.php', {'ip': ip})
                        .success(reloadTbl);

                });

                $('.btn-none').click(function() {

                    var ip = $(this).parent().parent().find('td a').text();

                    $.get('setNone.php', {'ip': ip})
                        .success(reloadTbl);

                });
            }
        });

        function reloadTbl(){
            tbl.draw(false);
        }
    });

</script>
<?php include_once('layout/footer.php'); ?>