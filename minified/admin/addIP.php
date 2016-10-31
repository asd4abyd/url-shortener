<?php include_once('layout/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Add New IP</h3></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <form action="view.php" method="post">
                        <div class="table">
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="tab">
                                <tbody>
                                <tr>
                                <td>Add IP</td>
                                <td><input style="width: 100%; border-radius: 5px; border: 1px solid #c4c4c4; padding: 2px 4px;" type="text" name="ip"/></td>
                                </tr>
                                <tr>
                                <td>&nbsp;</td>
                                <td><table style="width: 100%">
                                        <tr>
                                            <td><input type="radio" value="1" id="lbAllow" name="status" checked /><label for="lbAllow">Allow User</label></td>
                                            <td><input type="radio" value="2" id="lbBlock" name="status" /><label for="lbBlock">Block User</label></td>
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