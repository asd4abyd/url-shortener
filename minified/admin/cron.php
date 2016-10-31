<?php


require_once('../_config.php');


$db = new mysqli($db_host, $db_user, $db_pass, $db_base);
if ($db->connect_errno) {
    //echo "Unable to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
    die();
}

$result = $db->query("select `host` from bots_host ;");



while($_row = $result->fetch_object()){

    $ip=gethostbyname($_row->host);

    $db->query("insert into bots_ip (`ip`, `admin_status`) value ('$ip', '2') ON DUPLICATE KEY IGNORE;");

}
