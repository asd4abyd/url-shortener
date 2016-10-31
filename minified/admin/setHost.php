<?php include_once('layout/header.php'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Block Host</h3></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <form action="viewHost.php" method="post">
                            <div class="table">
                                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="tab">
                                    <colgroup>
                                        <col width="width:25%;" />
                                        <col width="width:75%;" />
                                    </colgroup>
                                    <tbody>
                                    <tr>
                                        <td>Add Block Host</td>
                                        <td><input style="width: 100%; border-radius: 5px; border: 1px solid #c4c4c4; padding: 2px 4px;" type="text" name="host" /></td>
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