<?php
/**
 * Created by PhpStorm.
 * User: Abdelqader Osama
 * Date: 10/17/15
 * Time: 10:31 PM
 */


$ip = isset($_GET['ip'])? $_GET['ip']: "";

if($ip=='') {
    header('Location: /');
    exit();
}

require_once('_additional.php');

$db = new mysqli($db_host, $db_user, $db_pass, $db_base);
if ($db->connect_errno) {
    //echo "Unable to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
    die();
}

$db->query("update bots_ip set admin_status = 0 where ip= '$ip';");
