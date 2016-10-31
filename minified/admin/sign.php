<?php

    session_start();

    $_SESSION['exp']=time()-3600;


if(isset($_POST['pass'])) {

    include_once('../_config.php');

    $db = new mysqli($db_host, $db_user, $db_pass, $db_base);
    if ($db->connect_errno) {
        //echo "Unable to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
        die();
    }

    $result = $db->query("select '1' as c from bots_settings where `key`='password' and `value`=md5('{$_POST['pass']}');");

    if($result->num_rows>0) {
        session_start();

        $_SESSION['key'] = true;
        $_SESSION['exp'] = time() +  3600; // add one hour

        header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // past date to encourage expiring immediately

        header('Location: index.php');
        exit();
    }
}

?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>HM-Developer</title>
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>-->
    <!--    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>-->
    <![endif]-->
    <!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>-->
    <!--    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.js"></script>-->

</head>
<body class="fixed-left">
<div class="wrapper-page">
    <div class="panel panel-color panel-primary panel-pages">
        <div class="panel-heading bg-img">
            <div class="bg-overlay"></div>
            <h3 class="text-center m-t-10 text-white"><strong>BOTS</strong> - Abyd.NET</h3></div>
        <div class="panel-body">
            <form class="form-horizontal m-t-20" method="post">
                <div class="form-group">
                    <div class="col-xs-12"><input class="form-control input-lg" type="password" name="pass" required=""
                                                  placeholder="Password"></div>
                </div>
                <div class="form-group text-center m-t-40">
                    <div class="col-xs-12">
                        <button class="btn btn-primary btn-lg w-lg waves-effect waves-light" type="submit">Log In
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>