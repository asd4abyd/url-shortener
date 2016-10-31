<?php

$password = isset($_POST['value1'])? $_POST['value1']: "";
$rePassword = isset($_POST['value2'])? $_POST['value2']: "";

require_once('_additional.php');


$db = new mysqli($db_host, $db_user, $db_pass, $db_base);
if ($db->connect_errno) {
    //echo "Unable to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
    die();
}
$save = false;

if($password!='' and $password==$rePassword) {

    $password = (intval($password)<=0?10:intval($password)) ;

    $db->query("update bots_settings set `value`=md5('$password') where `key`='password';");
    $save =true;
}

include_once('layout/header.php');

?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Change Password</h3></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <form action="setPassword.php" method="post">
                        <div class="table">
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="tab">
                                <colgroup>
                                    <col width="width:25%;" />
                                    <col width="width:75%;" />
                                </colgroup>
                                <tbody>
                                <?php if($save) { ?>
                                    <tr>
                                        <td colspan="2"><div class="alert alert-success">Password Has Saved</div></td>
                                    </tr>
                                <?php } ?>
                                    <tr>
                                        <td>Set Password</td>
                                        <td><input style="width: 100%; border-radius: 5px; border: 1px solid #c4c4c4; padding: 2px 4px;" type="text" name="value1" value="" /></td>
                                    </tr>
                                    <tr>
                                        <td>Re-enter Password</td>
                                        <td><input style="width: 100%; border-radius: 5px; border: 1px solid #c4c4c4; padding: 2px 4px;" type="text" name="value2" value="" /></td>
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