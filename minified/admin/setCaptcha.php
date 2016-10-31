<?php

$googleSiteKey = isset($_POST['value1'])? $_POST['value1']: "";
$googleSecretKey = isset($_POST['value2'])? $_POST['value2']: "";

$googleSiteKey = trim($googleSiteKey);
$googleSecretKey = trim($googleSecretKey);

require_once('_additional.php');



$db = new mysqli($db_host, $db_user, $db_pass, $db_base);
if ($db->connect_errno) {
    //echo "Unable to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
    die();
}

if($googleSiteKey!='' and $googleSecretKey!='') {
    $db->query("update bots_settings set `value`='$googleSiteKey' where `key`='Site Key';");
    $db->query("update bots_settings set `value`='$googleSecretKey' where `key`='Secret Key';");
}

$result = $db->query("select `value` from bots_settings where `key`='Site Key'");

$row = $result->fetch_row();
$v1 = $row[0];

$result = $db->query("select `value` from bots_settings where `key`='Secret Key'");

$row = $result->fetch_row();
$v2 = $row[0];

include_once('layout/header.php');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">set Google Captcha</h3></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <form action="setCaptcha.php" method="post">
                        <div class="table">
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="tab">
                                <colgroup>
                                    <col width="width:25%;" />
                                    <col width="width:75%;" />
                                </colgroup>
                                <tbody>
                                <tr>
                                <td>Google Site Key</td>
                                <td><input style="width: 100%; border-radius: 5px; border: 1px solid #c4c4c4; padding: 2px 4px;" type="text" name="value1" value="<?php echo $v1 ?>" /></td>
                                </tr>
                                <tr>
                                <td>Google Secret Key</td>
                                <td><input style="width: 100%; border-radius: 5px; border: 1px solid #c4c4c4; padding: 2px 4px;" type="text" name="value2" value="<?php echo $v2 ?>" /></td>
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