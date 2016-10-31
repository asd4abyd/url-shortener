<?php

$connections = isset($_POST['value'])? $_POST['value']: "";

require_once('_additional.php');


$db = new mysqli($db_host, $db_user, $db_pass, $db_base);
if ($db->connect_errno) {
    //echo "Unable to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
    die();
}

if($connections!='') {

    $connections = (intval($connections)<=0?10:intval($connections)) ;

    $db->query("update bots_settings set `value`='$connections' where `key`='connections per hour';");
}

$result = $db->query("select `value` from bots_settings where `key`='connections per hour'");

$row = $result->fetch_row();
$v = $row[0];
include_once('layout/header.php');

?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Add New IP</h3></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <form action="setConnections.php" method="post">
                        <div class="table">
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="tab">
                                <colgroup>
                                    <col width="width:25%;" />
                                    <col width="width:75%;" />
                                </colgroup>
                                <tbody>
                                <tr>
                                <td>Set Connection Number</td>
                                <td><input style="width: 100%; border-radius: 5px; border: 1px solid #c4c4c4; padding: 2px 4px;" type="text" name="value" value="<?php echo $v ?>" /></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><input type="submit" value="Save" />
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once('layout/footer.php'); ?>