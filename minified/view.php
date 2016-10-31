<html>
<head>
    <title>View IPs</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.9/datatables.min.css"/>
</head>
<body>

<div class="panel">
    <div class="panel-body">
        <div class="table-info">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="tab">
                <thead>
                    <tr>
                        <th>IP</th>
                        <th>Last Request</th>
                        <th>Status</th>
                        <th>Admin Permission</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div >
</div>


<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.9/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tab').DataTable({
            "ajax":  {
                "url": "getData.php",
                "type": "POST"
            },
            "processing": true,
            "aaSorting": [],
            "serverSide": true,

            "columns": [
                { "data": "ip" },
                { "data": "l_con" },
                { "data": "b" },
                { "data": "admin_b" }]
        });
    });
</script>
</body>
</html>