<?php

$captchaTest = isset($_POST['value'])? $_POST['value']: "";

require_once('_additional.php');

$db = new mysqli($db_host, $db_user, $db_pass, $db_base);
if ($db->connect_errno) {
    //echo "Unable to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
    die();
}

if($captchaTest!='') {

    $db->query("update bots_settings set `value`='$captchaTest' where `key`='use captcha';");
}

$result = $db->query("select `value` from bots_settings where `key`='use captcha'");

$row = $result->fetch_row();
$v = $row[0];
?>
<?php include_once('layout/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Set Block Method</h3></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <form action="setBlockMethod.php" method="post">
                        <div class="table">
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="tab">
                                <colgroup>
                                    <col width="width:25%;" />
                                    <col width="width:75%;" />
                                </colgroup>
                                <tbody>
                                <tr>
                                <td>Set Method</td>
                                <td>
                                    <table style="width: 100%">
                                        <tr>
                                            <td style="width:50%"><input name="value" value="true" <?php echo ($v=='true'?'checked':''); ?> type="radio" id="captcha" /><label for="captcha">Captcha</label></td>
                                            <td style="width:50%"><input name="value" value="false" <?php echo ($v!='true'?'checked':''); ?> type="radio" id="redirect" /><label for="redirect">Redirect Link</label></td>
                                        </tr>
                                    </table>
                                </td>
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